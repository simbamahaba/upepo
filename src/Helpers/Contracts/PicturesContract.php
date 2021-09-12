<?php
namespace Simbamahaba\Upepo\Helpers\Contracts;

interface PicturesContract
{
    /**
     * -------------------------------------------------------
     * The model is needed to find the correspondent table_id
     *  used to query for pictures in 'images' table.
     * -------------------------------------------------------
     *
     * @param string $modelName
     * @return $this
     */
    public function setModel($modelName);

    /**
     * ---------------------------------------------------------
     * Returns all pics for a table.
     * ---------------------------------------------------------
     *
     * @return array
     */
    public function getPics();

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
    public function recordPics($recordId, $withDescription = false);

    /**
     * -------------------------------------------------------------
     * Returns first pic for each record. Pics descriptions are
     * also provided if second param is set to "true".
     * -----------------------------------------------------------
     * @param bool $withDescription
     * @return array
     */
    public function recordsFirstPics($withDescription = false);
}