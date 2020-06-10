<?php

namespace App\Notifications;

use App\ApplicationShare;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewUserApplication extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * @var ApplicationShare
     */
    public $applicationShare;

    /**
     * Create a new notification instance.
     *
     * @param ApplicationShare $applicationShare
     */
    public function __construct(ApplicationShare $applicationShare)
    {
        $this->applicationShare = $applicationShare;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database', 'mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param mixed $notifiable
     * @return MailMessage
     */
    public function toMail($notifiable)
    {
        $position = ucfirst($this->applicationShare->position->name);
        return (new MailMessage)
            ->line("Dear ,$position there are new pending applications.")
            ->line("For your consideration and approval")
            ->action('Click Here To View Them', route('userApplication'))
            ->line('Thank you!');
    }


    /**
     * Get the array representation of the notification.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            'message' => 'New Application',
            'link' => route('userApplication', ['filter' => 'pending']),
        ];
    }
}
