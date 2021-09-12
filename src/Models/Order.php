<?php

namespace Simbamahaba\Upepo\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    public function items()
    {
        return $this->hasMany(Ordereditem::class);
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function transport()
    {
        return $this->belongsTo(Transport::class);
    }

    public function status()
    {
        return $this->belongsTo(Status::class);
    }

    public function proforma()
    {
        return $this->hasOne(Proforma::class);
    }

    /**
     * @return mixed|string
     */
    public function customerName()
    {
        if( $this->account_type == 0 && trim($this->name) != '' ){
            return $this->name;
        }
        if( $this->account_type == 1 && trim($this->company) != '' ){
            return $this->company;
        }

        return 'Unidentified customer';
    }

    public function finalPrice()
    {
        return number_format($this->price + $this->price_transport,2);
    }
}
