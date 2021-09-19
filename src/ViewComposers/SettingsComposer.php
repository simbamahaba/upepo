<?php

namespace Simbamahaba\Upepo\ViewComposers;

use Illuminate\View\View;
use Simbamahaba\Upepo\Models\SysSetting;
use Simbamahaba\Upepo\Models\Map;
class SettingsComposer
{
    protected $sysSettings;
    public function __construct(SysSetting $sysSetting)
    {
        $settings = $sysSetting->all();
        foreach($settings as $setting){
            $this->sysSettings[$setting->name] = $setting->value;
        }
        $map = Map::first();
        if( null == $map ){
            $this->sysSettings['address']='Map info not set.';
        }else{
            $this->sysSettings['address'] = $map->address;
        }
    }

    public function compose(View $view)
    {
        $view->with('site_settings', $this->sysSettings);
    }
}