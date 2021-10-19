<?php

namespace Simbamahaba\Upepo\Controllers\Admin;

use Simbamahaba\Upepo\Events\RecordDeletedEvent;
use Simbamahaba\Upepo\Services\Records;
use Illuminate\Support\Facades\Cache;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Simbamahaba\Upepo\Helpers\Traits\Core;
class RecordsController extends Controller
{
    use Core;

    private $records;

    public function __construct(Records $records)
    {
        $this->middleware('web');
        $this->middleware('admin.only');
        $this->records = $records;
        DB::connection()->enableQueryLog();
    }

    public function qry()
    {
        $queries = DB::connection()->getQueryLog();
        dump($queries);
    }


    /**
     * Returns all records from a table
     *
     * @param $tableName
     * @param $id
     * @return \Illuminate\Contracts\View\View|\Illuminate\Routing\Redirector
     */
    public function index($tableName, $id)
    {
//        Cache::flush();
        try{
            $settings = $this->getSettings($tableName);
        }catch (\Exception $e){
            $this->clearTableCoreCache($tableName);
            return redirect('admin/home')
                ->with('aborted', $e->getMessage());
        }

        $config = $this->getConfig($tableName);

        $currentUrl = route('records.index', [$tableName, $config['tableId']]);
        if( url()->current() !== $currentUrl){
            return redirect($currentUrl);
        }
//        $this->qry();
        return view('upepo::admin.records.index',
            [
                'records'       => $this->records->paginateRecords($settings),
                'id'            => (int)$id,
                'settings'      => $settings,
                'config'        => $config,
                'pics'          => $this->records->getMainImages($config),
                'filters'       => $this->records->generateFilters($settings),
                'spanActions'   => $this->records->getSpannedColumns($config),
            ]
        );
    }


    public function resetFilters(Request $request, $tableName)
    {
        return redirect()
            ->back()
            ->with('mesaj',$this->records->dropFilters($request, $tableName));
    }

    /**
     * Deletes a record in the specified table -- GET
     *
     * @param $tableName
     * @param $recordId
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function delete($tableName, $recordId)
    {
        $recordId = (int)$recordId;

        try{
            $settings = $this->getSettings($tableName);
            $config = $settings['config'];
            $record = $this->records->findViaModel($config['model'], $recordId);
        }catch(\TypeError $t){
            return redirect()
                ->back()
                ->with('danger', $t->getMessage());
        }catch(\Exception $e){
            return redirect()
                ->back()
                ->with('aborted', $e->getMessage());
        }

        if( $this->records->recordHasChildren($config['tableName'], $record->id) ){
            $name = strtoupper($record->{$config['displayedName']});
            return redirect()
                ->route('records.index', [$config['tableName'], $config['tableId']])
                ->with('mesaj',
                    "EROARE: Categoria $name are subcategorii. Va rugam sa stergeti mai intai subcategoriile.");
        }

        $record->delete();

        RecordDeletedEvent::dispatch($config, $recordId);

        return redirect()
            ->route('records.index', [$config['tableName'], $config['tableId']])
            ->with('mesaj', $settings['messages']['deleted']);
    }


    /**
     * Displays a page for creating a new record in the specified table
     *
     * @param string $tableName
     * @return \Illuminate\View\View
     */
    public function create($tableName)
    {
        return view('upepo::admin.records.create',[
            'settings' => $this->records->getOptions( $this->getSettings($tableName) ),
            ]);
    }


    /**
     * Stores a new record in the specified table
     *
     * @param Request $request
     * @param string $tableName
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request, $tableName)
    {
        $settings = $this->getSettings($tableName);
        $table = $this->getTableData($tableName);

        if( $this->records->storeRecord($settings, $request) ){
            $message = $settings['messages']['added'];
        }else{
            $message = 'EROARE! Elementul nu a fost adaugat.';
        }

        return redirect()->route('records.index', [$tableName,$table->id])->with('mesaj', $message);
    }


    /**
     * Edits a record
     *
     * @param $tableName
     * @param $recordId
     * @return \Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse
     */
    public function edit($tableName, $recordId)
    {
        $recordId = (int)$recordId;

        try{
            $settings = $this->getSettings( $tableName );
            $record = $this->records->findViaModel($settings['config']['model'], $recordId);
        }catch (\Exception $e){
            return redirect()
                ->back()
                ->with('aborted', $e->getMessage());
        }

        return view('upepo::admin.records.edit',[
            'record' => $record,
            'fields' => $this->records->getOptions($settings, $recordId),
            ]
        );
    }

    /**
     * Updates a record
     *
     * @param Request $request
     * @param $tableName
     * @param $recordId
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(Request $request, $tableName, $recordId)
    {
        $this->records->updateRecord($request, $tableName, $recordId);

        if( !session()->has('aborted') ){
            $request->session()->flash('mesaj', 'Schimbarea a fost realizata cu succes!');
        }

        return redirect()->route('record.edit', [$tableName, $recordId]);
    }

    public function deleteMany(Request $request, $tableName, $id)
    {
        $config = $this->getConfig($tableName);

        if($request->has('deleteItems') && $config['functionDelete'] != 1){
            return redirect()
                ->route('records.index', [$tableName, $id])
                ->with('aborted','Elementele nu pot fi sterse pentru aceasta tabela.');
        }

        $deleted = $this->records->deleteElements($request, $tableName, $config);
        $message = ($deleted)?"Un numar de $deleted de elemente au fost sterse.":"Niciun element nu a fost sters." ;

        return redirect()
            ->route('records.index', [$tableName, $id])
            ->with('mesaj', $message);

    }

    /**
     * @param Request $request
     * @param $tableName
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Throwable
     */
    public function updateOrder(Request $request, $tableName)
    {
        $message = 'Ordinea a fost schimbata cu succes!';
        $messageType = 'mesaj';

        try {
            $this->records->tableAcceptsReordering($tableName);
            $recordsToUpdate = $this->records->validateBeforeReordering($request);
            $this->records->updateOrder($recordsToUpdate, $tableName);
        }catch (\Exception $exception){
            $message = $exception->getMessage();
            $messageType = 'aborted';
        }

        return redirect()
            ->back()
            ->with($messageType, $message);

    }


    public function limit(Request $request, $tableName)
    {
        $this->validate($request,[
            'perPage' => 'required|integer|min:5'
        ]);

        $message = 'Numarul maxim de elemente afisate a ramas identic.';

        if($this->records->updateLimitPerPage($tableName, $request->perPage)){
            $message = 'Numarul maxim de elemente afisate a fost modificat cu succes!';
        }

        return redirect()->back()->with('mesaj', $message);
    }

}
