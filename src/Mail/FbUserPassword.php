<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Simbamahaba\Upepo\Models\SysSetting;
class FbUserPassword extends Mailable
{
    use Queueable, SerializesModels;
    public $password;
    public $name;
    private $system_email;
    private $site_name;
    public function __construct($name, $password)
    {
        $set = new SysSetting();
        $this->system_email = $set->property('system_email');
        $this->site_name = $set->property('site_name');
        $this->password = $password;
        $this->name = $name;
    }

    public function build()
    {
        return $this->from($this->system_email,$this->site_name)
                    ->subject('Parola contului creat pe '.$this->site_name)
                    ->view('decoweb::emails.fbpassword');
    }
}
