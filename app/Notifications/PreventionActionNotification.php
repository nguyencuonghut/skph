<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Lang;
use App\Models\Prevention;

class PreventionActionNotification extends Notification
{
    use Queueable;


    private $prevention;
    private $action;

    /**
     * Create a new notification instance.
     * PreventionActionNotification constructor.
     * @param $task
     * @param $action
     */
    public function __construct($prevention, $action)
    {
        $this->prevention = $prevention;
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
            case 'assigned_proposer':
                $text = __(':username giao cho bạn đề xuất biện pháp phòng ngừa', [
                    'title' =>  $this->prevention->proposer->name,
                    'username' =>  Auth()->user()->name,
                    ]);
                break;
            case 'request_to_approve':
                $text = __(':username yêu cầu bạn phê duyệt biện pháp phòng ngừa', [
                    'title' =>  $this->prevention->proposer->name,
                    'username' =>  Auth()->user()->name,
                ]);
                break;
            case 'approved':
                $text = __(':approver đã phê duyệt biện pháp phòng ngừa của bạn', [
                    'approver' =>  $this->prevention->approver->name,
                    'username' =>  Auth()->user()->name,
                ]);
                break;
            default:
                break;
        }
        return [
            'assigned_user' => $notifiable->id, //Assigned user ID
            'created_user' => $this->prevention->proposer->id,
            'message' => $text,
            'type' =>  Prevention::class,
            'type_id' =>  $this->prevention->id,
            'url' => url('descriptions/' . $this->prevention->id),
            'action' => $this->action
        ];
    }
}
