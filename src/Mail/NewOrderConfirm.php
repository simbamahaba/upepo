<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Simbamahaba\Upepo\Models\SysSetting;
class NewOrderConfirm extends Mailable
{
    use Queueable, SerializesModels;

    public $name;
    public $invoiceUrl;
    public $toAdmin;
    private $system_email;
    private $site_name;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($name, $invoiceUrl, $toAdmin = false)
    {
        $this->name = $name;
        $this->invoiceUrl = $invoiceUrl;
        $this->toAdmin = $toAdmin;
        $set = new SysSetting();
        $this->system_email = $set->property('system_email');
        $this->site_name = $set->property('site_name');
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from($this->system_email, $this->site_name)
                    ->subject('Comanda noua pe site-ul '.$this->site_name)
                    ->view('upepo::emails.newOrderConfirm');
    }
}
