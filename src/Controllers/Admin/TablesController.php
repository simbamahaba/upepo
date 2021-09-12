<?php

namespace Simbamahaba\Upepo\Controllers\Admin;

use Illuminate\Http\Request;
use Simbamahaba\Upepo\Services\Tables;
use Simbamahaba\Upepo\Requests\TableRequest;
use App\Http\Controllers\Controller;
use Simbamahaba\Upepo\Models\SysCoreSetup as Table;
use Simbamahaba\Upepo\Helpers\Traits\Core;

/**
 * Class TablesController
 * @package Decoweb\Panelpack\Controllers\Admin
 */
class TablesController extends Controller
{
    use Core;

    private $tables;

    public function __construct(Tables $tables)
    {
        $this->middleware('web');
        $this->middleware('admin.only');
        $this->tables = $tables;
    }

    /**
     * Displays all created tables
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $tabele = Table::orderBy('order')->orderBy('created_at')->get();
        return view('upepo::admin.tables.index', compact('tabele'));
    }


    /**
     * Displays a form for creating a new table
     *
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create(Request $request)
    {
        $columns = ($request->columns)?(int)$request->columns:1;
        $tabele = $this->tables->selectTablesOptions();
        $types = $this->tables->selectTypes();
        return view('upepo::admin.tables.create',compact('columns','tabele','types' ));
    }


    /**
     * Creates a new table, new Model & stores table's details in sys_core_setups
     *
     * @param TableRequest $request
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(TableRequest $request)
    {
//        dd($request->filesExt);
        $table = $this->tables->collectTableInfo($request);
//        dd($table);
        $this->tables->saveTableInfo($table);
//        dd($table);
        $tableCreated = $this->tables->createTable($table);

        $modelCreated = $this->tables->makeModel($table['config']['model']);

        return redirect('admin/table-settings')
            ->with('mesaj', $this->tables->messageTableCreated($tableCreated, $modelCreated));
    }


    /**
     * 1) Drops the specified table
     * 2) Clears table's cache
     * 3) Removes Eloquent model
     * 4) Deletes table's associated images
     * 5) Deletes corresponding settings in sys_core_setups
     *
     * @param Table $table
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \Exception
     */
    public function destroy(Table $table)
    {
        $table->delete();

        return redirect('admin/table-settings')->with('mesaj',"Table has been destroyed.");
    }

    /**
     * Updates the order of tables
     *
     * @param Request $request
     * @param Table $tb
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function updateOrder(Request $request, Table $tb)
    {
        $tables = $tb::select('id', 'order')->get();
        $flag = 0;
        foreach ($tables as $table) {
            $order = 'order_'.$table->id;

            if ($request->has($order) && $table->order != $request->$order && $request->$order >= 0){
                if (ctype_digit((string)trim($request->$order)) !== true) {
                    continue;
                }
                $table->order = (int)trim($request->$order);
                $table->save();
                ++$flag;
            }
        }
        $mesaj = ($flag === 0)? 'Ordinea tabelelor a ramas identica.':"{$flag} tabele au ordinea schimbata";
        $request->session()->flash('mesaj',$mesaj);
        return redirect('admin/table-settings');

    }


    /**
     * Returns a view for editing a table
     *
     * @param Table $table
     * @return \Illuminate\Contracts\View\View
     */
    public function edit(Table $table)
    {
        $settings = $this->getSettings($table->table_name);
//        dd($settings['elements']);
        $options = $this->tables->selectTablesOptions();

        $types = $this->tables->selectTypes();

        return view('upepo::admin.tables.edit',[
            'table'     => $table,
            'settings'  => $settings,
            'tabele'    => $options,
            'types'     => $types,
        ]);
    }

    /**
     * 1) Updates the configuration of the specified table in sys-core-setups
     * 2) Modifies the column structure of the table (by calling a private method)
     *
     * @param Request $request
     * @param Table $table
     */
    public function update(Request $request, Table $table)
    {
        # Unserialize table's settings
        $setup = $this->getSettings($table->table_name);

        $tableColumns = array_keys($setup['elements']); // stabilim care sunt coloanele existente
            // Daca in $request apar coloane noi, trebuie adaugate
            // Daca in $request nu apar dintre cele vechi, trebuie

       /* foreach( $setup as $section => $attributes){
            if( $section == 'config' || $section == 'messages'){
                foreach($attributes as $attribute=>$value) {
                    if ( $request->has($attribute) ) {
                        $setup[$section][$attribute] = $request->$attribute;
                    }
                }
            }elseif( $section == 'filter' ){
                if( $request->has('filter') && ! empty($request->filter) ){
                    $setup['filter'] = explode(',',trim(str_replace(' ','',$request->filter)));
                }
            }elseif( $section == 'elements'){
                if( $request->has('elements') && count($request->elements) != 0 ){
                    $setup = $this->storeColumnsInfo($request, $setup);
                }
            }
        }*/
        dump($setup);
        dump($tableColumns);
        dd($request->all());
    }

}
