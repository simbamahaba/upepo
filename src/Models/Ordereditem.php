<?php

namespace Simbamahaba\Upepo\Models;

use Illuminate\Database\Eloquent\Model;

class Ordereditem extends Model
{
    public $timestamps = false;

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

}
