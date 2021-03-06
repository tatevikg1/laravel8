<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Message;
// use Illuminate\Contracts\Broadcasting\ShouldBroadcast;


class NewMessage extends Notification implements ShouldQueue //, ShouldBroadcast
{
    use Queueable;

    public $message;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Message $message)
    {
        $this->message = $message;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toDatabase($notifiable)
    {
        return [
            'id' => $this->message->id,
        ];
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
            'id' => $this->message->id,
            'notifiable' => $notifiable,
        ];

    }

    // /**
    //  * Get the broadcastable representation of the notification.
    //  *
    //  * @param  mixed  $notifiable
    //  * @return BroadcastMessage
    //  */
    // public function toBroadcast($notifiable)
    // {
    //     return new BroadcastMessage([
    //         'id' => $this->message->id,
    //     ]);
    // }

    // /**
    //  * Get the type of the notification being broadcast.
    //  *
    //  * @return string
    //  */
    // public function broadcastType()
    // {
    //     return 'NewMessageNotification';
    // }

}
