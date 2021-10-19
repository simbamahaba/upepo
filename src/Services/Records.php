<?php

namespace Simbamahaba\Upepo\Services;

use App\Http\Controllers\Controller;
use Simbamahaba\Upepo\Exceptions\RecordException;
use Simbamahaba\Upepo\Exceptions\TableDefinition;
use Simbamahaba\Upepo\Helpers\Contracts\PicturesContract;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Simbamahaba\Upepo\Helpers\Traits\Core;
use Illuminate\Support\Str;

class Records extends Controller
{
    use Core;

    /**
     * @param $config
     * @param \Illuminate\Database\Query\Builder $query
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator|LengthAwarePaginator
     */
    public function paginateRecords($settings)
    {
        $config = $settings['config'];

        $query = DB::table($config['tableName']);
        $this->selectColumnsWithParent($config, $query);
        $this->applyFilters($query, $settings);

        $requestHasValidOrderBy = false;
        $hasOrderByOrder = false;
        $appends = null;

        if ($this->requestHasOrderByQueryString($config)) {
            $query->orderBy(request('order'), request('dir'));
            $requestHasValidOrderBy = true;
            $appends[] = 'order|' . request('order');
            $appends[] = 'dir|' . request('dir');
            if (request('order') == 'order') $hasOrderByOrder = true;
        }

        if ($config['functionSetOrder'] == 1 && $hasOrderByOrder == false) {
            $query->orderBy('order');
        };
        $query->orderBy('created_at', 'desc');

        if ($config['functionRecursive'] == 1) {
            $records = $query->get()->toArray();
            $tree = $this->drawTree($records, $config['displayedName'], $config['recursiveMax']);
            $paginated = $this->paginate($tree, $config, $appends);
        } else {
            $records = $query->paginate($config['limitPerPage']);
            $paginated = (!$requestHasValidOrderBy)?$records:$records->withQueryString();
        }
        return $paginated;
    }

    /**
     * @param $settings
     * @param Request $request
     * @return mixed
     * @throws \Illuminate\Validation\ValidationException
     */
    public function storeRecord($settings, Request $request)
    {
        $config = $settings['config'];
        $elements = $settings['elements'];

        $model = $this->makeDynamicModel($config['model']);
        $newRecord = $this->newRecordViaModel($config['model']);

        $rules = $this->generateRules($elements, $config['tableName']);

        $this->validate($request, $rules);

        foreach ($elements as $column => $data) {
            if ($data['type'] == 'checkbox') {
                $newRecord->$column = (!empty($request->$column) && $request->$column == 'on') ? 1 : 2;
            } else {
                $colType = explode('|', $data['colType']); # We need to set manually decimal columns to NULL if input is empty ("")
                if ($colType[0] == 'decimal' && trim($request->$column) == '') {
                    $newRecord->$column = null;
                } else {
                    $newRecord->$column = $request->$column;
                }
            }
            # Storing the record's slug
            if ($column === $config['displayedName']) {
                $newRecord->slug = Str::slug($request->$column);
            }

        }
        if ($config['functionVisible'] == 1) {
            $newRecord->visible = (!empty($request->visible) && $request->visible == 'on') ? 1 : 2;
        }
        if ($config['functionSetOrder'] == 1) {
            $order = $model::max('order');
            $order = (int)$order + 1;
            $newRecord->order = $order;
        }
        return $newRecord->save();
    }

    public function updateRecord($request, $tableName, $recordId)
    {
        $recordId = (int)$recordId;

        $settings = $this->getSettings($tableName);
        $record = $this->findViaModel($settings['config']['model'], $recordId);

//        dd($settings);
//        dd($record);

        $rules = $this->generateRules($settings['elements'], $tableName);

        $this->validate($request, $rules);

        foreach($settings['elements'] as $column=>$data){

            if( $data['type'] == 'select' && $this->recordHasChildren($tableName, $recordId) ){
                if( (int)$request->$column > 0 ){
                    $request->session()->flash('aborted','Modificare nereusita. Acesta categorie are deja subcategorii.');
                    return false;
                }
            }
            if($data['type'] == 'checkbox'){
                # 1 is always the default value:
                # enum|nu,da -> "nu" is default
                $record->$column = (!empty($request->$column) && $request->$column == 'on')?2:1;
            }else{
                $colType = explode('|',$data['colType']); # We need to set manually decimal columns to NULL if input is empty ("")
                if( $colType[0] == 'decimal' && trim($request->$column) == '' ){
                    $record->$column = null;
                }else{
                    $record->$column = $request->$column;

                    # Updates record's slug
                    if($column === $settings['config']['displayedName']){
                        $record->slug = Str::slug($request->$column);
                    }
                }
            }

        }
        if($settings['config']['functionVisible'] == 1){
            $record->visible = (!empty($request->visible) && $request->visible == 'on')?1:2;
        }
        return $record->save();
    }

    /**
     * Checks if the request has valid orderBy clauses:
     * order=order/name/visible, dir=asc/desc
     *
     * @param $config
     * @return bool
     */
    public function requestHasOrderByQueryString($config)
    {
        if( !request()->has('order') && !request()->has('dir')) return false;

        if ( !in_array(request('order'), ['order', 'visible', $config['displayedName']]) ||
            !in_array(request('dir'), ['asc', 'desc'])
        ) return false;

        return true;
    }

    /**
     * @param $config
     * @param \Illuminate\Database\Query\Builder $query
     */
    public function selectColumnsWithParent($config, \Illuminate\Database\Query\Builder $query): void
    {
        if ($config['functionRecursive'] == 0) {
            $query->select('id', 'order', 'created_at', $config['displayedName'], 'visible');
        } else {
            $query->select('id', 'order', 'created_at', $config['displayedName'], 'parent', 'visible');
        }
    }

    /**
     * Rearranges records as "parent-child"
     *
     * @param array $array
     * @param $displayedName
     * @param $recursiveMax
     * @param int $deep
     * @param int $parent
     * @param array $result
     * @return array|mixed
     */
    private function drawTree(array $array, $displayedName, $recursiveMax, $deep = 0, $parent = 0, &$result = array()){

        if ($parent != 0){
            $deep++;
        }
        foreach ($array as $key => $data){
            if ( $data->parent == $parent ){
                if ($parent != 0){
                    $pad = str_repeat('&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;',$deep);
                    $data->$displayedName = $pad.$data->$displayedName;
                }
                $result[] = $data;
                if ($deep < $recursiveMax){
                    $this->drawTree($array, $displayedName, $recursiveMax, $deep, $data->id, $result);
                }
            }
        }
        return $result;
    }

    public function getRecursiveIds($selectTable, $parentId, &$in = [])
    {
        $ids = DB::table( $selectTable )->where('parent', $parentId)->pluck('id')->toArray();
        foreach ($ids as $id){
            $in[] = $id;
            $this->getRecursiveIds($selectTable, $id, $in);
        }

        return $in;
    }


    /**
     * @param $query
     * @param $settings
     * @return $this|null
     */
    public function applyFilters($query, $settings)
    {
        if( empty($settings['filter']) ) return null;

        foreach($settings['filter'] as $filter){
            if( request()->has($filter) && !empty(request($filter)) ){
                session( ['filters.'.$settings['config']['tableName'].'.'.$filter => trim(request($filter))] );
                // Merge si metoda urmatoare:
                //session()->put( 'filters.'.$settings['config']['tableName'].'.'.$filter, trim(request($filter)) );
            }
        }

        if( session()->has('filters.'.$settings['config']['tableName']) ){

            foreach( session('filters.'.$settings['config']['tableName']) as $filter =>$filterValue){

                if ( $settings['elements'][$filter]['type'] == 'select' ){
                    # Sa aflam daca categoriile au subcategorii
                    if( Schema::hasColumn( $settings['elements'][$filter]['selectTable'],'parent') ){
                        # daca au subcategorii, urmeaza sa le colectam id-urile
                        # $filterValue este id-ul categoriei careia ii cautam subcat.
                        $in = $this->getRecursiveIds($settings['elements'][$filter]['selectTable'],$filterValue);
                        $in[] = $filterValue;
                        $query->whereIn($filter,$in);
                    }else{
                        $query->where($filter,$filterValue);
                    }
                }

                if ( $settings['elements'][$filter]['type'] == 'text' ){
                    $query->where($filter,'like','%'.$filterValue.'%');
                }
            }
        }
        return $this;
    }

    /**
     * Verifica daca id-ul inregistrarii se afla in coloana
     * "parent". Daca da, inseamna ca aceasta inregistrare
     * are cel putin o subcategorie.
     *
     * @param $tableName
     * @param $recordId
     * @return bool
     */
    public function recordHasChildren($tableName, $recordId)
    {
        if(!$this->tableHasParentColumn($tableName) ) return false;
        $parentIds = $this->getParents($tableName);
        return in_array((int)$recordId, $parentIds);
    }


    public function getParents($tableName)
    {
        $parentIds = DB::table($tableName)->pluck('parent')->toArray();
        return array_filter($parentIds);
    }

    /**
     * Generates validation rules for storing a new record
     *
     * @param array $elements
     * @param $tableName
     * @return array|bool
     */
    public function generateRules(array $elements, $tableName)
    {
        if(!is_array($elements) || empty($elements)){
            return false;
        }
        $rules = [];
        $colsWithLength = ['varchar','char'];
        $length = '';
        $decimal = '';
        foreach ($elements as $column=>$data){
            $required = ($data['required'] == 1 && $data['type'] != 'checkbox')?'required|':'';
            $colType = explode('|',$data['colType']);
            if( $colType[0] == 'decimal'){
                list($total,$decimals) = explode(',',$colType[1]);
                $total = str_repeat('9',$total - $decimals);
                $decimals = str_repeat('9',$decimals);
                $decimal = "numeric|max:{$total}.{$decimals}|";
            }elseif( in_array($colType[0], $colsWithLength)){
                $length = 'max:' . $colType[1] .'|';
            }
            if( $data['type'] == 'select'){
                $ids = DB::table($data['selectTable'])->pluck('id')->toArray();
                //dd($ids);
                $ids = implode(',',$ids);

                if($data['selectTable'] == $tableName){
                    $ids .= ',0';
                }
                /*dd($tableName);
                dd($data['selectTable']);*/
                $select = "integer|in:{$ids}|";
            }else{
                $select = '';
            }
            $rules[$column] = trim("{$required}{$select}{$decimal}{$length}",'|');
            if(empty($rules[$column])){
                unset($rules[$column]);
            }
            $length = '';
            $decimal = '';
        }

        //dd($rules);
        return $rules;
    }


    /**
     * @param array $settings
     * @param null $excludeCurrentRecordId
     * @return array
     */
    public function getOptions(array $settings, $excludeCurrentRecordId = false)
    {
        if( !in_array('select', array_column($settings['elements'], 'type')) ){
            return $settings;
        };
        foreach($settings['elements'] as &$field){
            if($field['type'] == 'select'){
                if ( $field['selectTable'] != $settings['config']['tableName']) {
                    $parentSettings = $this->getSettings($field['selectTable']);
                    $sameTable = false;
                }else{
                    $parentSettings = $settings;
                    $sameTable = true;
                }

                $orderBy = ($parentSettings['config']['functionSetOrder'] == 1)?'order':'created_at';
                // Check if parent table is recursive (if it has categories and subcategories)
                if(array_key_exists('parent',$parentSettings['elements'])){
                    $excludedId = ($excludeCurrentRecordId && $sameTable)?(int)$excludeCurrentRecordId:'';
                    $optionsToArray = DB::table($field['selectTable'])
                        ->select('id','parent',$parentSettings['config']['displayedName'])
                        ->where('id','!=',$excludedId)
                        ->orderBy($orderBy)
                        ->get()
                        ->toArray();
                    // CREATE - Daca tabela este aceeasi: recursiveMax -= 1
                    // EDIT - Daca tabela este aceeasi: la fel. In plus, trebuie exclus ID-ul editat din lista de optiuni
                    $recursiveMax = ($sameTable)?$parentSettings['config']['recursiveMax'] - 1:$parentSettings['config']['recursiveMax'];
                    $options = $this->drawTree($optionsToArray, $parentSettings['config']['displayedName'],$recursiveMax );
                    //$options = $this->drawTree($toArray, $parentSettings['config']['displayedName'],$parentSettings['config']['recursiveMax'] );
                }else{
                    $options = DB::table($field['selectTable'])
                        ->select('id', $parentSettings['config']['displayedName'])
                        ->orderBy($orderBy)
                        ->get()
                        ->toArray();
//                    $options = $this->valuesToArray($options);
                }

                if($settings['config']['functionRecursive'] == 1 && $field['selectTable'] == $settings['config']['tableName']){
                    $firstEntry = 'Categorie principalaa';
                }else{
                    $firstEntry = '';
                }

                $default = (empty($field['selectFirstEntry']))?$firstEntry:$field['selectFirstEntry'];
                $field['options'][] = $default;

                foreach($options as $option){
                    $field['options'][$option->id] = $option->{$parentSettings['config']['displayedName']};
                }
            }
        }

        return $settings;
    }


    /**
     * @param array $arrayOfObjects
     * @return array[]
     */
    public function valuesToArray(array $arrayOfObjects)
    {
        return array_map(function ($value) {
            return (array) $value;
        }, $arrayOfObjects);
    }

    /**
     * @param $tree
     * @param $config
     * @param null $appends
     * @return LengthAwarePaginator
     */
    public function paginate($tree, $config, $appends = null)
    {
        //Get current page form url e.g. &page=6
        $currentPage = LengthAwarePaginator::resolveCurrentPage();

        //Create a new Laravel collection from the array data
        $collection = new Collection($tree);

        //Define how many items we want to be visible in each page
        $perPage = $config['limitPerPage'];

        //Slice the collection to get the items to display in current page
        $currentPageSearchResults = $collection->slice(($currentPage - 1) * $perPage, $perPage)->all();

        //Create our paginator and pass it to the view
        $paginated = new LengthAwarePaginator($currentPageSearchResults, count($collection), $perPage);
        if( $appends !== null ) {
            foreach($appends as $request){
                list($key, $value) = explode('|',$request);
                $paginated->appends($key, $value);
            }
        }
        return $paginated;
    }


    /**
     * Generates filters data
     *
     * @param string $tableName
     * @return array|false
     */
    public function generateFilters($settings)
    {

        if( empty(array_filter($settings['filter'])) ) {
            return false;
        }

        $thisTable = $settings['config']['tableName'];
        $filterColumns = $settings['filter'];
        $elements = $settings['elements'];

        $filters = [];
        $filterKey = 0;
        foreach($filterColumns as $filterColumn){
            if(array_key_exists($filterColumn,$elements)){
                if( $elements[$filterColumn]['type'] == 'select'){
                    if( $elements[$filterColumn]['selectTable'] != $thisTable){
                        $filters[$filterKey]['type'] = 'select';
                        $filters[$filterKey]['column'] = $filterColumn;
                        $filters[$filterKey]['name'] = $elements[$filterColumn]['friendlyName'];

                        $newSettings = $this->getOptions($settings);
                        $filters[$filterKey]['options'] = $newSettings['elements'][$filterColumn]['options'];
                    }
                }
                if( $elements[$filterColumn]['type'] == 'text'){
                    $filters[$filterKey]['type'] = 'text';
                    $filters[$filterKey]['column'] = $filterColumn;
                    $filters[$filterKey]['name'] = $elements[$filterColumn]['friendlyName'];
                }
            }
            ++$filterKey;
        }
        return $filters;
    }


    /**
     * Calculates how many columns must be spanned
     * in the records table head
     *
     * @param array $settings
     * @return int
     */
    public function getSpannedColumns(array $config): int
    {
        return (int)$config['functionImages'] +
            (int)$config['functionDelete'] +
            (int)$config['functionEdit'] +
            (int)$config['functionFile'];
    }

    /**
     * @param $tableName
     * @param $itemsPerPage
     * @return bool
     */
    public function updateLimitPerPage($tableName, $itemsPerPage)
    {
        $table = $this->getTableData($tableName);
        $settings = $this->getSettings($table->table_name);

        if( $settings['config']['limitPerPage'] == $itemsPerPage ){
            return false;
        }

        $settings['config']['limitPerPage'] = $itemsPerPage;
        $table->settings = $this->updateSettings($settings);
        $table->save();

        $this->clearTableCoreCache($table->table_name);

        return true;
    }

    /**
     * @param $tableName
     * @return bool
     * @throws \Throwable
     */
    public function tableAcceptsReordering($tableName)
    {
        $config = $this->getConfig($tableName);

        throw_if( $config['functionSetOrder'] != 1,
            TableDefinition::tableAcceptsNotReordering($tableName));

        return true;
    }

    /**
     * @param $request
     * @return mixed
     * @throws \Throwable
     */
    public function validateBeforeReordering($request)
    {
        $records_to_update = array_filter(array_diff_assoc($request->orderId, $request->oldOrderId), function($k, $v){
            return ctype_digit(trim($k)) && ctype_digit(trim($v)) && $k > 0 && $v > 0;
        }, ARRAY_FILTER_USE_BOTH);

        throw_if( !count( $records_to_update ) > 0,
            \Exception::class,
            'Ordinea inregistrarilor a ramas neschimbata.');

        return $records_to_update;
    }


    /**
     * @param $records_to_update
     * @param $tableName
     */
    public function updateOrder($records_to_update, $tableName): void
    {
        foreach ($records_to_update as $record_id => $record_order) {
            DB::table($tableName)
                ->select(['id', 'order'])
                ->where('id', $record_id)
                ->update(['order' => $record_order]);
        }
    }

    public function deleteImages()
    {

    }


    /**
     * Drops existing filters of a table.
     *
     * @param $request
     * @param string $tableName
     * @return string
     */
    public function dropFilters($request, string $tableName): string
    {
        if( $request->session()->has('filters.'.$tableName) ){
            $request->session()->forget('filters.'.$tableName);
            return 'Filtrele au fost sterse cu succes!';
        }
         return 'Filtre inexistente.';
    }

    /**
     * @param $config
     * @return null
     */
    public function getMainImages($config)
    {
        if( $config['functionImages'] != 1 ){
            return null;
        }

        $images = App::make(PicturesContract::class);
        return $images->setModel($config['model'])->recordsFirstPics();
    }

    public function deleteElements($request, $tableName, $config)
    {
        $model = $this->makeDynamicModel( $config['model'] );

        if( $request->has('item') && is_array($request->item) && count($request->item) > 0){
            $toDelete = [];

            foreach($request->item as $itemKey=>$item){
                $record = $model::find((int)$itemKey);
                if( !is_null($record) && $this->recordHasChildren($tableName,$record->id) ){
                    continue;
                }
                $toDelete[] = $itemKey;
            }

            $model::whereIn('id',$toDelete)->delete();

            return count($toDelete);
        }else{
            return false;
        }
    }

    /**
     * @param $modelName
     * @param int $id
     * @return mixed
     * @throws RecordException
     */
    public function findViaModel($modelName, int $id)
    {
        $model = $this->makeDynamicModel($modelName);
        $record = $model::find($id);
        if( ! $record instanceof $model ){
            throw RecordException::notFound($id);
        };
        return $record;
    }

    /**
     * @param $modelName
     * @return mixed
     */
    public function newRecordViaModel($modelName)
    {
        $model = $this->makeDynamicModel($modelName);
        return new $model();
    }

    /**
     * @param string $modelName
     * @return string
     */
    public function makeDynamicModel(string $modelName): string
    {
        return 'App\\Models\\' . trim($modelName);
    }
}
