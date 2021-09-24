<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Simbamahaba\Upepo\Models\SysSetting;
class ContactUs extends Mailable
{
    use Queueable, SerializesModels;

    private $system_email;
    private $site_name;
    public $name;
    public $senderEmail;
    public $about;
    public $phone;
    public $bodyMessage;

    public function __construct($name, $senderEmail, $about, $phone, $bodyMessage)
    {
        $set = new SysSetting();
        $this->system_email = $set->property('system_email');
        $this->site_name = $set->property('site_name');

        $this->name = $name;
        $this->senderEmail = $senderEmail;
        $this->about = $about;
        $this->phone = $phone;
        $this->bodyMessage = $bodyMessage;
    }

    public function build()
    {
        return $this->from($this->system_email)
                    ->replyTo($this->senderEmail)
                    ->subject('Mesaj nou de pe site-ul '.$this->site_name)
                    ->text('upepo::emails.contact_plain');
    }
}
