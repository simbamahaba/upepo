<?php
namespace Simbamahaba\Upepo\Helpers\Traits;

use Simbamahaba\Upepo\Models\SysCoreSetup;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Schema;
use Simbamahaba\Upepo\Exceptions\TableDefinition;
trait Core
{
    /**
     * Gets TABLE DATA from database.sys_core_setups & caches it forever
     *
     * @param string $tableName
     * @return mixed
     */
    public function getTableData(string $tableName)
    {
        $tableName = trim($tableName);
        $method= __METHOD__;
        $data = Cache::rememberForever('core_'.$tableName, function() use ($tableName, $method) {

            $data = SysCoreSetup::table( $tableName );

            if( ! $data instanceof SysCoreSetup ) {
                throw TableDefinition::notfound($tableName);
            };

            return $data;
        });

        return $data;
    }

    public function findOrFail($id)
    {
        return SysCoreSetup::findOrfail($id);
    }

    /**
     * @param $data
     * @return false|mixed
     */
    protected function decodeSettings($data)
    {
        if($data === false) return false;
        return json_decode($data->settings, true);
    }

    protected function updateSettings(array $settings)
    {
        return json_encode($settings);
    }

    /**
     * @param string $tableName
     * @return false|mixed
     */
    public function getSettings(string $tableName)
    {
        $tableData = $this->getTableData($tableName);
        $settings = $this->decodeSettings($tableData);
        $settings['config']['tableId'] = $tableData->id;

        return $settings;
    }

    public function getConfig( string $tableName)
    {
        $settings = $this->getSettings($tableName);
        if(!is_array($settings) || !array_key_exists('config', $settings)){
            return false;
        }
        return $settings['config'];
    }

    /**
     * Clear the cache of a table
     *
     * @param $tableName
     * @return bool
     */
    public function clearTableCoreCache($tableName)
    {
        $keys = [
            'core_'.trim($tableName),
        ];

        $count = 0;

        foreach ($keys as $key) {
            if (Cache::has($key)) {
                Cache::forget($key);
                $count++;
            }
        }
        return $count;
    }

    /**
     * Clears the cache list of tables in admin panel
     *
     * @return bool
     */
    public function clearSidebarMenu()
    {
        if( Cache::has('sidebar_tables') ){
            Cache::forget('sidebar_tables');
            return true;
        }
        return false;
    }

    /**
     * @param string $tableName
     * @return bool
     */
    public function tableExists(string $tableName)
    {
        return Schema::hasTable($tableName);
    }


    /**
     * @param string $tableName
     * @return bool
     */
    public function tableHasParentColumn(string $tableName)
    {
      return array_key_exists('parent', $this->getSettings($tableName)['elements'] );
    }

    /**
     * @param string $tableName
     * @return bool
     */
    public function tableHasImages(string $tableName)
    {
        $settings = $this->getSettings($tableName);
        return (bool)$settings['config']['functionImages'];
    }

    /**
     * Checks if the specified table accepts files uploads
     *
     * @param string $tableName
     * @return bool
     * @throws TableDefinition
     */
    public function tableHasFiles(string $tableName)
    {
        $config = $this->getConfig($tableName);
        if( !$config['functionFile'] ){
            throw TableDefinition::tableAcceptsNoFiles($tableName);
        };
        return true;
    }
}
