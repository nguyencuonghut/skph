<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Lang;
use App\Models\Description;

class DescriptionActionNotification extends Notification
{
    use Queueable;


    private $description;
    private $action;

    /**
     * Create a new notification instance.
     * TaskActionNotification constructor.
     * @param $task
     * @param $action
     */
    public function __construct($description, $action)
    {
        $this->description = $description;
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
                $text = __(':title được tạo bởi :creator, và giao cho bạn', [
                    'title' =>  $this->description->title,
                    'creator' => $this->description->user->name,
                    ]);
                break;
            case 'leader_approved':
                $text = __(':title được xác nhận bởi :leader', [
                    'title' =>  $this->description->title,
                    'leader' => $this->description->leader->name,
                ]);
                break;
            case 'leader_rejected':
                $text = __(':title bị từ chối xác nhận bởi :leader', [
                    'title' =>  $this->description->title,
                    'leader' => $this->description->leader->name,
                ]);
                break;
            case 'effectiveness_asset':
                $text = __(':title được đánh giá hiệu quả bởi :username', [
                    'title' =>  $this->description->title,
                    'username' => $this->description->effectiveness_user->name,
                ]);
                break;
            case 'updated_status':
                $text = __(':title được đánh dấu hoàn thành bởi :username', [
                    'title' =>  $this->description->title,
                    'username' =>  Auth()->user()->name,
                    ]);
                break;
            case 'updated_time':
                $text = __(':username inserted a new time for :title', [
                    'title' =>  $this->description->title,
                    'username' =>  Auth()->user()->name,
                    ]);
                break;
            case 'updated_assign':
                $text = __(':username assigned a task to you', [
                    'title' =>  $this->description->title,
                    'username' =>  Auth()->user()->name,
                    ]);
                break;
            default:
                break;
        }
        return [
            'assigned_user' => $notifiable->id, //Assigned user ID
            'created_user' => $this->description->user->id,
            'message' => $text,
            'type' =>  Description::class,
            'type_id' =>  $this->description->id,
            'url' => url('descriptions/' . $this->description->id),
            'action' => $this->action
        ];
    }
}
