<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Simbamahaba\Upepo\Models\Customer;
class YourAccountWasCreatedManually extends Notification
{
    use Queueable;
    protected $customer;
    protected $password;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Customer $customer, $password)
    {
        $this->customer = $customer;
        $this->password = $password;
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
                    ->line('Datele de autentificare: ')
                    ->line('User: '.$this->customer->email)
                    ->line('Parola: '.$this->password)
                    ->action('Intra in cont', url('customer/login'));
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
