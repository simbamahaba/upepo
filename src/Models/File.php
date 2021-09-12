<?php

namespace Simbamahaba\Upepo\Models;

use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    public function table()
    {
        return $this->belongsTo(SysCoreSetup::class,'table_id');
    }
}
