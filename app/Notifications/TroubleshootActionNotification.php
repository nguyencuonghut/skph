<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Lang;
use App\Models\Troubleshoot;

class TroubleshootActionNotification extends Notification
{
    use Queueable;


    private $troubleshoot;
    private $action;

    /**
     * Create a new notification instance.
     * TroubleshootActionNotification constructor.
     * @param $task
     * @param $action
     */
    public function __construct($troubleshoot, $action)
    {
        $this->troubleshoot = $troubleshoot;
        $this->action = $action;
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
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
       /* return (new MailMessage)
                    ->line('The introduction to the notification.')
                    ->action('Notification Action', 'https://laravel.com')
                    ->line('Thank you for using our application!'); */
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        switch ($this->action) {
            case 'created':
                $text = __(':title was created by :creator, and assigned to you', [
                    'title' =>  $this->troubleshoot->title,
                    'creator' => $this->troubleshoot->user->name,
                    ]);
                break;
            case 'assigned_troubleshooter':
                $text = __(':username assigned a troubleshoot to you', [
                    'title' =>  $this->troubleshoot->troubleshooter->name,
                    'username' =>  Auth()->user()->name,
                    ]);
                break;
            case 'request_to_approve':
                $text = __(':username request you to approve the troubleshoot action', [
                    'title' =>  $this->troubleshoot->troubleshooter->name,
                    'username' =>  Auth()->user()->name,
                ]);
                break;
            case 'approved':
                $text = __(':approver approved your troubleshoot action', [
                    'approver' =>  $this->troubleshoot->approver->name,
                    'username' =>  Auth()->user()->name,
                ]);
                break;
            default:
                break;
        }
        return [
            'assigned_user' => $notifiable->id, //Assigned user ID
            'created_user' => $this->troubleshoot->troubleshooter->id,
            'message' => $text,
            'type' =>  Troubleshoot::class,
            'type_id' =>  $this->troubleshoot->id,
            'url' => url('descriptions/' . $this->troubleshoot->id),
            'action' => $this->action
        ];
    }
}
