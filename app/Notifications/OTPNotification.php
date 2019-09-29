<?php

namespace App\Notifications;

use Bitfumes\KarixNotificationChannel\KarixChannel;
use Bitfumes\KarixNotificationChannel\KarixMessage;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class OTPNotification extends Notification
{
    use Queueable;
    private $OTP;
    private $via;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($OTP, $via)
    {
        $this->OTP = $OTP;
        $this->via = $via;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return $this->via == 'sms'? [KarixChannel::class] : ['mail'];
    }

    public function toKarix($notifiable)
    {
        return KarixMessage::create()
            ->to('+2348123641748')
            ->from('+2348123641748')
            ->content("Your OTP is {$this->OTP}");
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
                    ->markdown('OTP', ['OTP' => $this->OTP]);
//                    ->line('The introduction to the notification.')
//                    ->action('Notification Action', url('/'))
//                    ->line('Thank you for using our application!');
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
