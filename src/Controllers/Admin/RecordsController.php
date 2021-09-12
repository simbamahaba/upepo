<?php

namespace Simbamahaba\Upepo\Controllers\Admin;

use Simbamahaba\Upepo\Events\RecordDeletedEvent;
use Simbamahaba\Upepo\Services\Records;
use Dompdf\Image\Cache;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
//use Illuminate\Support\Facades\Schema;
//use Decoweb\Panelpack\Models\SysCoreSetup;
//use Decoweb\Panelpack\Models\Image as Poza;
use Illuminate\Support\Facades\DB;
//use Illuminate\Pagination\LengthAwarePaginator;
//use Illuminate\Pagination\Paginator;
//use Illuminate\Support\Collection;
//use Illuminate\Support\Facades\Cache;
//use Illuminate\Support\Str;
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
     * @return \Illuminate\View\View
     */
    public function index($tableName, $id)
    {
        Cache::clear();
        $tableData = $this->getTableData($tableName);
        $settings = $this->getSettings($tableName);

        if ($settings === false) {
            $this->clearTableCoreCache($tableName);
            return redirect('admin/home')->with('aborted', 'Tabela nu exista in baza de date.');
        }

        $currentUrl = route('records.index', [$tableName, $tableData->id]);
        if( url()->current() !== $currentUrl){
            return redirect($currentUrl);
        }

        $config = $settings['config'];

//        $this->qry();
        return view('upepo::admin.records.indexb',
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
        $settings = $this->getSettings($tableName);
        $config = $settings['config'];

        $record = $this->records->findViaModel($config['model'], $recordId);

        # If the record doesn't exist...
        if(!$record){
            return redirect()
                ->route('records.index', [$config['tableName'], $config['tableId']])
                ->with('mesaj', 'Inregistrare inexistenta.');
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
     * @return \Illuminate\Routing\Redirector
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
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($tableName, $recordId)
    {
        $recordId = (int)$recordId;
        $settings = $this->getSettings( $tableName );
        $fields = $this->records->getOptions($settings, $recordId);
        $record = $this->records->findViaModel($settings['config']['model'], $recordId);

        if( null === $record){
            return redirect('admin/core/'.trim($tableName))->with('aborted','Inregistrare inexistenta');
        }

        return view('upepo::admin.records.edit',['record'=>$record, 'fields'=>$fields]);
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

    public function updateOrder(Request $request, $tableName)
    {
        $table = $this->getTableData($tableName);
        $message = 'Ordinea a fost schimbata cu succes!';

        try {
            $this->records->tableAcceptsReordering($tableName);
            $recordsToUpdate = $this->records->validateBeforeReordering($request);
            $this->records->updateOrder($recordsToUpdate, $tableName);
        }catch (\Exception $exception){
            $message = $exception->getMessage();
        }

        return redirect()
            ->route('records.index', [$tableName, $table->id])
            ->with('mesaj', $message);

    }


    /**
     * Update records' order | Delete multiple records
     *
     * @param Request $request
     * @param         $tableName
     * @return \Illuminate\Http\RedirectResponse
     */
    public function recordsActions(Request $request, $tableName)
    {
        $tableName = (string)trim($tableName);
        $tableData = $this->getTableData($tableName);
        if( !$tableData ){
            return redirect('admin/core/'.$tableName)->with('aborted','Tabela nu exista. [EROARE GRAVA]');
        }
        $fields = $this->getSettings($tableName);

        if($request->has('changeOrder') && $fields['config']['functionSetOrder'] != 1){
            return redirect('admin/core/'.$tableName)->with('aborted','Ordinea nu poate fi setata pentru aceasta tabela.');
        }
        if($request->has('deleteItems') && $fields['config']['functionDelete'] != 1){
            return redirect('admin/core/'.$tableName)->with('aborted','Elementele nu pot fi sterse pentru aceasta tabela.');
        }

        $modelName = $tableData->model;
        $model = '\App\\'.$modelName;
        $message = '';
        if( $request->has('changeOrder') && $request->changeOrder == 1 ) {
            if( $request->has('orderId') && is_array($request->orderId) && count($request->orderId) > 0 ){
                foreach($request->orderId as $id=>$newOrder){
                    $record = $model::find((int)$id);
                    if( $record && $newOrder != $record->order && $newOrder >= 0 ){
                        if ( ctype_digit((string) trim($newOrder)) !== true ) {
                            continue;
                        }
                        $record->order = (int)$newOrder;
                        $record->save();
                    }else{
                        continue;
                    }
                }
                $message = 'Ordinea a fost schimbata cu succes!';
            }
        }
        if( $request->has('deleteItems') && $request->deleteItems == 1){
            if( $request->has('item') && is_array($request->item) && count($request->item) > 0){
                $toDelete = [];
                foreach($request->item as $itemKey=>$item){
                    $record = $model::find((int)$itemKey);
                    if( !is_null($record) && $this->records->recordHasChildren($tableName,$record->id) ){
                        continue;
                    }
                    $toDelete[] = $itemKey;
                }
                $howMany = count($toDelete);
                $model::whereIn('id',$toDelete)->delete();
                $message = "Un numar de $howMany de elemente au fost sterse.";
            }else{
                $message = "Niciun element nu a fost sters.";
            }
        }

        return redirect('admin/core/'.$tableName)->with('mesaj', $message);
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
