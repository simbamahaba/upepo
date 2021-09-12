<?php
namespace Simbamahaba\Upepo\Helpers;

use Simbamahaba\Upepo\Helpers\Contracts\PicturesContract;
use Simbamahaba\Upepo\Models\Image;
use Simbamahaba\Upepo\Models\SysCoreSetup;
class Pictures implements PicturesContract
{
    private $table_id;
    private $pics = [];

    /**
     * -------------------------------------------------------
     * The model is needed to find the correspondent table_id
     *  used to query for pictures in 'images' table.
     * -------------------------------------------------------
     *
     * @param string $modelName
     * @return $this
     */
    public function setModel($modelName)
    {
        unset($this->table_id);
        $this->pics=[];
        $table = SysCoreSetup::select('id')->where('model',trim((string)$modelName))->first();
        $this->table_id = ( !is_null($table) )?(int)$table->id:null;
        return $this;
    }

    /**
     * ----------------------------------------------------
     * Collects all pics for a table.
     * ----------------------------------------------------
     *
     * @param array $moreWhere
     * @return mixed
     */
    private function collectPics(array $moreWhere = [])
    {
        $items = new Image();
        $items->newQuery();
        return $items->where( array_merge(['table_id'=>$this->table_id], $moreWhere) )
            ->orderBy('ordine')
            ->oldest()
            ->get();
    }

    /**
     * ---------------------------------------------------------
     * Returns all pics for a table.
     * ---------------------------------------------------------
     *
     * @return array
     */
    public function getPics()
    {
        foreach ($this->collectPics() as $pic){
            $this->pics[$pic->record_id][] = $pic->name;
        }
        return $this->pics;
    }

    /**
     * -------------------------------------------------------------
     * Returns first pic for each record. Pics descriptions are
     * also provided if second param is set to "true".
     * -----------------------------------------------------------
     * @param bool $withDescription
     * @return array
     */
    public function recordsFirstPics($withDescription = false)
    {
        foreach ($this->collectPics() as $pic){
            if(array_key_exists($pic->record_id, $this->pics)) continue;
            if( $withDescription === true ){
                $this->pics[$pic->record_id] = ['name'=>$pic->name,'description'=>$pic->description];
            }else{
                $this->pics[$pic->record_id] = $pic->name;
            }
        }
        return $this->pics;
    }

    /**
     * -----------------------------------------------------------
     * Returns all pics for a specified record. Pic description is
     * also provided if second param is set to "true".
     * -----------------------------------------------------------
     *
     * @param      $recordId
     * @param bool $withDescription
     * @return array
     */
    public function recordPics($recordId, $withDescription = false)
    {
        $recordId = (int)$recordId;
        foreach ($this->collectPics(['record_id' =>$recordId]) as $pic){
            if( $withDescription === true ){
                $this->pics[] = ['name'=>$pic->name,'description'=>$pic->description];
            }else{
                $this->pics[] = $pic->name;
            }
        }
        return $this->pics;
    }
}