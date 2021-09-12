<?php
namespace Simbamahaba\Upepo\Helpers\Filters;


class ItemFilters extends QueryFilter
{

    /*
     Add the following method to the Model
    public function scopeFilter($builder, QueryFilter $filters)
    {
        return $filters->apply($builder);
    }
    */
    public function date( $order = 'desc')
    {
        return $this->builder->orderBy('created_at', $order);
    }

    public function name( $order = 'desc')
    {
        return $this->builder->orderBy('name', $order);
    }

    public function price( $order = 'desc')
    {
        return $this->builder->orderBy('pret', $order);
    }
}