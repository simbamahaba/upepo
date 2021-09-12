<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Simbamahaba\Upepo\Models\Customer;
class AccountCreatedManuallyNeedsConfirmation extends Notification
{
    use Queueable;
    protected $customer;
    protected $password;
    protected $token;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Customer $customer, $password, $token)
    {
        $this->customer = $customer;
        $this->password = $password;
        $this->token = $token;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->subject('Contul dumneavoastra a fost creat')
                    ->greeting('Buna ziua,')
                    ->line('Contul dumneavoastra pe site-ul '.config('app.name').' a fost creat.')
                    ->line('Inainte de a va loga, este obligatoriu sa confirmati prezenta adresa de email.\n 
                    Pentru aceasta, va rugam sa dati click pe urmatorul buton:')
                    ->action('Confirma email', url('customer/confirmemail/'.$this->token))
                    ->line('Datele de autentificare (valabile DUPA confirmarea adresei de email): ')
                    ->line('User - '.$this->customer->email)
                    ->line('Parola - '.$this->password);
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
