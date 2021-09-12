<?php

namespace Simbamahaba\Upepo\Models;

use Illuminate\Database\Eloquent\Model;

class SysSetting extends Model
{
    public $timestamps = false;

    public function property($name)
    {
       $site = $this->select('value')->where('name',$name)->first();
        return $site->value;
    }
}
