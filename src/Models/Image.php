<?php

namespace Simbamahaba\Upepo\Models;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    public function table()
    {
        return $this->belongsTo(SysCoreSetup::class,'table_id');
    }
}
