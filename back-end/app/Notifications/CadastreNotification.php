<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\User;

class CadastreNotification extends Notification
{
    use Queueable;
    private $user;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    // MAIL_USERNAME=7a50f743fc673f //gomesejcm@gmail.com
    // MAIL_PASSWORD=02f55b9705d36a  //ztjgixffjtisoybn
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
        $url = url('/invoice/'.$this->invoice->id);
        $user = $notifiable;
        return (new MailMessage)
                    ->subject('Confirmação de cadastro InterAct')
                    ->greeting($user->name.'. Seja bem vindo a InterAct!')
                    ->line($this->user->body.'Clique no botão a baixo e confirm se cadastro')
                    ->action('Confirmar cadastro', $url('/'))
                    ->line('Obrigada por escolher a InterAct!');
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
