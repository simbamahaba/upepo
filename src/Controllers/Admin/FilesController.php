<?php
namespace Simbamahaba\Upepo\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Simbamahaba\Upepo\Exceptions\TableDefinition;
use Simbamahaba\Upepo\Models\File;
use Illuminate\Support\Facades\Storage;
use Simbamahaba\Upepo\Helpers\Traits\Core;
use Simbamahaba\Upepo\Services\Records;
class FilesController extends Controller
{
    use Core;

    private $records;

    public function __construct(Records $records)
    {
        $this->middleware('web');
        $this->middleware('admin.only');
        $this->records = $records;
    }


    /**
     * Displays a page for adding a new file for a specified table record
     *
     * @param $tabela
     * @param $recordId
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function create($tabela, $recordId)
    {
        try {
            $config = $this->getConfig($tabela);
            $this->tableHasFiles($tabela);
        }catch (TableDefinition $e){
            return redirect()
                ->back()
                ->with('aborted',$e->getMessage());
        }

        $recordId = (int)$recordId;

        $settings = $this->getSettings($tabela);

        $record = $this->records->findViaModel($config['model'], $recordId);

        if(null == $record){
            return redirect()->back();
        }
        $files = File::where('table_id', $config['tableId'])
            ->where('record_id',$recordId)->orderBy('ordine','asc')->get();

        $filesMax = (int)$config['filesMax'];
        $name = $config['displayedName'];
        $pageName =  $config['pageName'];
        $noFiles = $settings['messages']['no_files'];

        return view('upepo::admin.files.create',[
            'filesMax'  => $filesMax,
            'record'    => $record,
            'name'      => $name,
            'tabela'    => $tabela,
            'idTabela'  => $config['tableId'],
            'pageName'  => $pageName,
            'files'     => $files,
            'noFiles'   => $noFiles,
        ]);
    }

    /**
     * Stores a file for a specified table record
     *
     * @param Request $request
     * @param $tabela
     * @param $recordId
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request, $tabela, $recordId)
    {
        try {
            $config = $this->getConfig($tabela);
            $this->tableHasFiles($tabela);
            $record = $this->records->findViaModel($config['model'], $recordId);
        }catch (\Exception $e){
            return redirect()
                ->back()
                ->with('aborted',$e->getMessage());
        }

        $allowedMimetypes = $this->getAllowedMimeTypes($config);

        $this->validate($request,[
            'title' => 'required|max:100',
            'file'  => "required|file|mimetypes:$allowedMimetypes",
        ],[
            'title.required'    => 'Fisierul trebuie sa aiba un nume.',
            'file.mimetypes'    => 'Formatul fisierului nu este adecvat. Formate acceptate: '.$config['filesExt'],
        ]);


        $filesMax = (int)$config['filesMax'];

        // Compare number of files in Files for the record with $filesMax
        $ordine = File::where('table_id', $config['tableId'])->where('record_id',$recordId)->max('ordine');
        $files_already_added = File::where('table_id', $config['tableId'])->where('record_id',$recordId)->count();

        if($filesMax == (int)$files_already_added){
            $request->session()->flash('mesaj',"Numarul maxim de fisiere a fost deja atins ($files_already_added).");
            return redirect('admin/core/'.$tabela.'/addFile/'.$recordId);
        }

        // Store file info in Files table
        $time = strval(time());
        $fileName = $tabela.'_ID'.$config['tableId'].'_'.$recordId.'_'.$time.'.'.$request->file('file')->getClientOriginalExtension();

        $file = new File();
        $file->table_id = $config['tableId'];
        $file->record_id = (int)$recordId;
        $file->ordine = ++$ordine;
        $file->name = $fileName;
        $file->title = (empty($request->title))?null:$request->title;
        $file->save();

        // Store file on disk
//      $disk = ( config('app.env') == 'production' )?'files':'files_dev';
        $path = trim(strtolower($config['tableName']))."/$recordId/";
        Storage::disk('uploaded_files')->putFileAs($path, $request->file('file'), $fileName);
        $request->session()->flash('mesaj','Fisierul a fost adugat cu succes!');
        return redirect('admin/core/'.$tabela.'/addFile/'.$recordId);
    }

    private function getAllowedMimeTypes($config)
    {
        $types = [
          'pdf'  => 'application/pdf',
          'txt'  => 'text/plain',
          'odt'  => 'application/vnd.oasis.opendocument.text',
          'xls'  => 'application/vnd.ms-excel',
          'xlsx' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
          'doc'  => 'application/msword',
          'docx' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
            // application/vnd.openxmlformats-officedocument.wordprocessingml.document
          'ppt'  => 'application/vnd.ms-powerpoint',
          'pptx' => 'application/vnd.openxmlformats-officedocument.presentationml.presentation',
        ];

        $extentions = explode(',', $config['filesExt']);
        $allowed = [];

        foreach($extentions as $extention){
            $extention = trim($extention);
            if(array_key_exists($extention, $types)){
                $allowed[] = $types[$extention];
            }
        }

        return implode(',',$allowed);
    }
    /**
     * Deletes a file name from "files" table.
     * This action is observed by FileObserver
     * which deletes the psysical file from storage.
     *
     * @param File $file
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function delete(File $file)
    {
        $file->delete();
        return redirect()->back()->with('mesaj','Fisierul a fost sters!');
    }

    /**
     * Updates the order and the description for a file
     *
     * @param Request $request
     * @param $tableId
     * @param $recordId
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(Request $request, $tableId, $recordId)
    {
        if( !ctype_digit($tableId) || !ctype_digit($recordId) ){
            return redirect('/');
        }
        $tableId = (int)$tableId;
        $recordId = (int)$recordId;

        $recordFiles = File::where('table_id', $tableId)->where('record_id', $recordId)->orderBy('ordine')->get();

        if ( null === $recordFiles ){
            return redirect()->back();
        }

        foreach($recordFiles as $recordFile){
            $ordine = 'ordine_'.$recordFile->id;
            $title = 'title_'.$recordFile->id;
            if( $request->has($ordine) ) {
                if(strcmp($recordFile->title, $request->$title) !== 0 || $recordFile->ordine != $request->$ordine){

                    if (ctype_digit((string)trim($request->$ordine)) !== true) {
                        continue;
                    }

                    $this->validate($request,[
                        $title => 'required|max:100'
                    ]);

                    $recordFile->title = (empty($request->$title))?null:$request->$title;
                    $recordFile->ordine = $request->$ordine;
                    $recordFile->save();
                }
            }
        }

        return redirect()->back();
    }
}
