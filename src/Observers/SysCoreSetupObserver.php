<?php

namespace Decoweb\Panelpack\Observers;

use Illuminate\Support\Facades\App;
use Simbamahaba\Upepo\Models\SysCoreSetup;
use Simbamahaba\Upepo\Services\Tables;
use Simbamahaba\Upepo\Helpers\Traits\Core;
use Illuminate\Support\Facades\Storage;

class SysCoreSetupObserver
{

    use Core;

    /**
     * Handle the SysCoreSetup "deleted" event:
     *
     * 1) Drops physical table
     * 2) Removes Model file
     * 3) Removes associated directory with images
     * 4) Removes associated directory with files
     * 5) Clears table's cache
     * 6) Clears the sidebar menu cache
     *
     * Images and Files names in "images" & "files" tables are
     * deleted "on cascade".
     *
     * @param  SysCoreSetup  $sysCoreSetup
     * @return void
     */
    public function deleted(SysCoreSetup $sysCoreSetup)
    {
        $tables = App::make(Tables::class);

        $tables->dropTable($sysCoreSetup->table_name);

        $tables->removeEloquentModel($sysCoreSetup->model);

        if( $this->tableHasImages($sysCoreSetup->table_name) ){
            Storage::disk('uploads')->deleteDirectory('/'.$sysCoreSetup->table_name);
        }

        if( $this->tableHasFiles( $sysCoreSetup->table_name) ){
            Storage::disk('uploaded_files')->deleteDirectory('/'.$sysCoreSetup->table_name);
        }

        $this->clearTableCoreCache($sysCoreSetup->table_name);

        $this->clearSidebarMenu();
    }

    public function created()
    {
        $this->clearSidebarMenu();
    }
}
