<?php
namespace Simbamahaba\Upepo\ViewComposers;

use Simbamahaba\Upepo\Models\SysCoreSetup;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\View;

class TablesMenuComposer
{
    protected $tablesMenu;

    public function __construct()
    {
//        Cache::flush();
        $this->tablesMenu = $this->toMenu();
    }

    private function toMenu()
    {
        $sidebar_menu = Cache::rememberForever('sidebar_tables', function(){
            $tables = SysCoreSetup::select('id','name', 'table_name')->orderBy('order')->get();
            $menu= "<div class=\"menu_section\"><h3>Pagini</h3><ul class=\"nav side-menu\">";
            foreach($tables as $table){
                $menu .= "<li><a href=\"".url('admin/core/'.$table->table_name.'/id/'.$table->id.'/')."\"><i class=\"fa fa-angle-double-right\"></i> ".$table->name."</a></li>";
            }
            $menu .= "</ul></div>";
            return $menu;
        });

        return $sidebar_menu;
    }

    public function compose(View $view)
    {
        $view->with('tabele', $this->tablesMenu);
    }


}
