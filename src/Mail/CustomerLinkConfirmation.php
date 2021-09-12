<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Simbamahaba\Upepo\Models\SysSetting;
class CustomerLinkConfirmation extends Mailable
{
    use Queueable, SerializesModels;

    public $customerName;
    public $emailToken;
    private $system_email;
    private $site_name;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($customerName,$emailToken)
    {
        $set = new SysSetting();
        $this->system_email = $set->property('system_email');
        $this->site_name = $set->property('site_name');

        $this->customerName = $customerName;
        $this->emailToken = $emailToken;

    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from($this->system_email,$this->site_name)
                    ->subject('Confirmare email')
                    ->view('decoweb::emails.emailconfirm');
    }
}
