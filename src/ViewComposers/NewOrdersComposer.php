<?php

namespace Simbamahaba\Upepo\ViewComposers;

use Illuminate\View\View;
use Simbamahaba\Upepo\Models\Order;
class NewOrdersComposer
{
    protected $newOrders;
    /**
     * Create a new profile composer.
     *
     * @param  UserRepository  $users
     * @return void
     */
    public function __construct(Order $order)
    {
        // Dependencies automatically resolved by service container...
        $this->newOrders = $order->where('read',1)->get();
    }

    /**
     * Bind data to the view.
     *
     * @param  View  $view
     * @return void
     */
    public function compose(View $view)
    {
        $view->with('newOrders', $this->newOrders->count());
    }
}