<?php

namespace Simbamahaba\Upepo\Services;

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Simbamahaba\Upepo\Models\SysCoreSetup;
use Simbamahaba\Upepo\Helpers\Traits\Core;
class Tables
{
    use Core;
    private $forbiddenTables =[
        'brand_category',
        'brands',
        'category_option',
        'customers',
        'images',
        'invoices',
        'migrations',
        'options',
        'ordereditems',
        'orders',
        'password_resets',
        'proformas',
        'statuses',
        'sessions',
        'shoppingcart',
        'sys_core_options',
        'sys_settings',
        'transports',
        'users',
    ];
    private $configFields = [
        'string'=>[
            'tableName',
            'pageName',
            'model',
            'displayedName',
            'displayedFriendlyName',
            'filesExt',

        ],
        'limitPerPage',
        'functionAdd',
        'functionEdit',
        'functionDelete',
        'functionSetOrder',
        'functionImages',
        'imagesMax',
        'functionFile',
        'filesMax',
        'functionVisible',
        'functionCreateTable',
        'functionRecursive',
        'recursiveMax',
    ];
    private $messageFields = [
        'add',
        'edit',
        'no_images',
        'no_files',
        'added',
        'deleted',
    ];
    private $hasParents = 0;

    public function selectTablesOptions()
    {
        $allTables = SysCoreSetup::select('id','name','table_name')->get();
        $selectOptions[] = '';
        foreach($allTables as $t){
            $selectOptions[$t->table_name] = $t->name . " ($t->table_name)";
        }
        return $selectOptions;

    }

    public function selectTypes()
    {
        $types = ['text','textarea','editor','select','checkbox','calendar'];
        $options = [];
        foreach ($types as $type){
            $options[$type] = $type;
        }
        return $options;
    }

    public function collectTableInfo($request)
    {
        $validated = $request->validated();

        $table = [];

        foreach($this->configFields as $key=>$field){
            if(is_array($field) && $key == 'string'){
                foreach($field as $f){
                    $table['config'][$f] = trim( $validated[$f] );
                }
            }else{
                if( empty($validated[$field]) ){
                    $table['config'][$field] = 0;
                }else{
                    $table['config'][$field] = (int)$validated[$field];
                }
            }
        }

        foreach($this->messageFields as $message){
            $table['messages'][$message] = trim( $validated[$message] );
        }

        if(array_key_exists('filter', $validated)){
            //dd($validated['filter']);
            $filters = explode(',',$validated['filter']);
            foreach($filters as $filter){
                $table['filter'][] = $filter;
            }
        }else{
            $table['filter'][]='';
        }

        foreach ($validated['elements'] as $element) {
            $required = (int) $element['required'];
            $table['elements'][$element['databaseName']] = [
                'friendlyName' => $element['friendlyName'],
                'type' => $element['type'],
                'required' => $required,
                'colType' => $element['colType'],
            ];

            if ( trim($element['type']) == 'text' ) {
                $readonly = (isset($element['readonly'])) ? (int) $element['readonly'] : 0;
                $table['elements'][$element['databaseName']]['readonly'] = $readonly;
            }
            if ( trim($element['type']) == 'select' ) {
                $multiple = (isset($element['selectMultiple'])) ? (int) $element['selectMultiple'] : 0;
                $first = (isset($element['selectFirstEntry'])) ? trim($element['selectFirstEntry']) : '';
                $extra = (isset($element['selectExtra'])) ? trim($element['selectExtra']) : '';

                $table['elements'][$element['databaseName']]['selectMultiple'] = $multiple;
                $table['elements'][$element['databaseName']]['selectFirstEntry'] = $first;
                $table['elements'][$element['databaseName']]['selectTable'] = trim($element['selectTable']);
                $table['elements'][$element['databaseName']]['selectExtra'] = $extra;
            }
        }
//        dd($table);
        return $table;
    }

    public function saveTableInfo($table)
    {
        $tabela = new SysCoreSetup();
        $tabela->name = $table['config']['pageName'];
        $tabela->table_name = $table['config']['tableName'];
        $tabela->model = $table['config']['model'];
        $tabela->settings = json_encode($table);
        $tabela->order = SysCoreSetup::max('order') + 1;
        $tabela->visible = $table['config']['functionVisible'];
        $tabela->save();

//        return $table;
    }

    public function createTable($table)
    {
        $tableName = $table['config']['tableName'];
        if( $table['config']['functionCreateTable'] != 1 || Schema::hasTable($tableName) ) {
            return false;
        }

        Schema::create($tableName, function (Blueprint $tab) use ($table) {
            $tab->engine = 'InnoDB';
            $tab->increments('id');

            foreach ($table['elements'] as $column => $property) {
                $type = '';
                $length = '';

                $this->hasParents += ($property['type'] == 'select')? 1 : 0;

                $param = explode('|', $property['colType']);
                switch (trim($param[0])) {
                    case 'varchar':
                        $type = 'string';
                        $length = (int)$param[1];
                        break;
                    case 'text':
                        $type = 'text';
                        break;
                    case 'int':
                        $type = 'integer';
                        break;
                    case 'decimal':
                        $type = 'decimal';
                        $decimal = explode(',',$param[1]);
                        $decimal[0] = (int)trim($decimal[0]);
                        $decimal[1] = (int)trim($decimal[1]);
                        break;
                    case 'enum':
                        $type = 'enum';
                        $enum = explode(',',$param[1]);
                        $enum[0] = (string)trim($enum[0]);
                        $enum[1] = (string)trim($enum[1]);
                        break;
                    default: throw new \Exception("Tipul de date pentru coloana '$column' este invalid.");
                }

                if ($property['required'] == 1) {
                    if (isset($length) && !empty($length)) {
                        $tab->$type($column, $length);
                        unset($length);
                    }elseif(isset($decimal) && !empty($decimal) && is_array($decimal)){
                        $tab->$type($column,$decimal[0],$decimal[1]);
                        unset($decimal);
                    }elseif(isset($enum) && !empty($enum) && is_array($enum)){
                        $tab->$type($column,$enum)->default($enum[0]);
                        unset($enum);
                    }else {
                        if($property['type'] == 'select'){
                            if ($table['config']['functionRecursive'] == 1){
                                $column = 'parent';
                            }
                            $tab->integer($column, false,true)->nullable();
                        }else{
                            $tab->$type($column);
                        }
                    }
                } else {
                    if (isset($length) && !empty($length)) {
                        $tab->$type($column, $length)->nullable();
                        unset($length);
                    }elseif(isset($decimal) && !empty($decimal) && is_array($decimal)){
                        $tab->$type($column,$decimal[0],$decimal[1])->nullable();
                        unset($decimal);
                    }elseif(isset($enum) && !empty($enum) && is_array($enum)){
                        $tab->$type($column,[ $enum[0], $enum[1] ])->nullable();
                        unset($enum);
                    }else {
                        if($property['type'] == 'select'){
                            $tab->$type($column, false,true)->nullable();
                        }else{
                            $tab->$type($column)->nullable();
                        }
                    }
                }
            }
            if($table['config']['functionSetOrder'] === 1){
                $tab->integer('order',false,true)->nullable();
            }
            if($table['config']['functionVisible'] === 1){
                $tab->tinyInteger('visible')->default(1);
            }
            $tab->string('slug');
            $tab->timestamps();
        });

        if($this->hasParents > 0){
            if(Schema::hasTable($tableName)) {
                Schema::table($tableName, function (Blueprint $newTable) use ($table) {
                    foreach($table['elements'] as $column => $property){
                        if($property['type'] == 'select' && $table['config']['functionRecursive'] != 1) {
                            $newTable->foreign($column)->references('id')->on($property['selectTable'])->onDelete('set null');
                        }
                    }

                });
            }
        }

        return true;
    }

    public function makeModel($model)
    {
        $model = (string)trim($model);
        if ( ctype_alpha($model) !== true ){
            return false;
        }
        $model = ucfirst( strtolower($model) );
        $draft =<<<BOB
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class $model extends Model
{
    //
}
BOB;
        return file_put_contents("../app/Models/$model".".php", $draft);

    }

    public function messageTableCreated($tableCreated, $modelCreated)
    {
        return 'okkkkkkk';
    }

    /**
     * @param $tableName
     * @return bool
     */
    public function dropTable($tableName)
    {
        $tableName = trim($tableName);
        if( !in_array($tableName, $this->forbiddenTables) ){
            Schema::dropIfExists($tableName);
            return true;
        }
        return false;
    }

    /**
     * @param $model
     * @return bool
     */
    public function removeEloquentModel($model)
    {
        $model = "../app/Models/".trim($model).".php";
        return unlink(realpath($model));
    }
}
