<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class OrderStatusChange extends Mailable
{
    use Queueable, SerializesModels;
    public $orderId;
    public $toAdmin;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($orderId, $toAdmin = false)
    {
        $this->orderId = (int)$orderId;
        $this->toAdmin = (bool)$toAdmin;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Statusul comenzii a fost schimbat')
            ->view('upepo::emails.OrderStatusChange');
    }
}
