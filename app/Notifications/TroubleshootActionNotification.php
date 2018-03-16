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
        return ['database', 'mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $url = url('/descriptions/'.$this->troubleshoot->id);
        $toName = '';
        switch ($this->action) {
            case 'created':
                $text = __(':title được tạo bởi :creator, và giao cho bạn', [
                    'title' =>  $this->troubleshoot->descriptionTitle,
                    'creator' => $this->troubleshoot->user->name,
                ]);
                $toName = $this->troubleshoot->user->name;
                break;
            case 'assigned_troubleshooter':
                $text = __(':title, :username giao cho bạn xử lý vấn đề', [
                    'title' =>  $this->troubleshoot->descriptionTitle,
                    'username' =>  Auth()->user()->name,
                ]);
                $toName = $this->troubleshoot->troubleshooter->name;
                break;
            case 'request_to_approve':
                $text = __(':title, :username yêu cầu bạn phê duyệt biện pháp khắc phục', [
                    'title' =>  $this->troubleshoot->descriptionTitle,
                    'username' =>  Auth()->user()->name,
                ]);
                $toName = $this->troubleshoot->approver->name;
                break;
            case 'approved':
                $text = __(':title, :approver đã đồng ý biện pháp khắc phục của bạn', [
                    'title' =>  $this->troubleshoot->descriptionTitle,
                    'approver' =>  $this->troubleshoot->approver->name,
                ]);
                $toName = $this->troubleshoot->troubleshooter->name;
                break;
            case 'rejected':
                $text = __(':title, :approver đã từ chối biện pháp khắc phục của bạn', [
                    'title' =>  $this->troubleshoot->descriptionTitle,
                    'approver' =>  $this->troubleshoot->approver->name,
                ]);
                $toName = $this->troubleshoot->troubleshooter->name;
                break;
            case 'seriously':
                $text = __(':title, :approver đã đánh giá SKPH của bạn là nghiêm trọng', [
                    'title' =>  $this->troubleshoot->descriptionTitle,
                    'approver' =>  $this->troubleshoot->evaluater->name,
                ]);
                $toName = $this->troubleshoot->troubleshooter->name;
                break;
            case 'normally':
                $text = __(':title, :approver đã đánh giá SKPH của bạn là không nghiêm trọng', [
                    'title' =>  $this->troubleshoot->descriptionTitle,
                    'approver' =>  $this->troubleshoot->evaluater->name,
                ]);
                $toName = $this->troubleshoot->troubleshooter->name;
                break;
            default:
                break;
        }
        return (new MailMessage)
            ->subject('Thông báo phiếu C.A.R')
            ->action('Thông báo', $url)
            ->line($toName)
            ->line($text);
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
                    'title' =>  $this->troubleshoot->descriptionTitle,
                    'creator' => $this->troubleshoot->user->name,
                    ]);
                break;
            case 'assigned_troubleshooter':
                $text = __(':title, :username giao cho bạn xử lý vấn đề', [
                    'title' =>  $this->troubleshoot->descriptionTitle,
                    'username' =>  Auth()->user()->name,
                    ]);
                break;
            case 'request_to_approve':
                $text = __(':title, :username yêu cầu bạn phê duyệt biện pháp khắc phục', [
                    'title' =>  $this->troubleshoot->descriptionTitle,
                    'username' =>  Auth()->user()->name,
                ]);
                break;
            case 'approved':
                $text = __(':title, :approver đã đồng ý biện pháp khắc phục của bạn', [
                    'title' =>  $this->troubleshoot->descriptionTitle,
                    'approver' =>  $this->troubleshoot->approver->name,
                ]);
                break;
            case 'rejected':
                $text = __(':title, :approver đã từ chối biện pháp khắc phục của bạn', [
                    'title' =>  $this->troubleshoot->descriptionTitle,
                    'approver' =>  $this->troubleshoot->approver->name,
                ]);
                break;
            case 'seriously':
                $text = __(':title, :approver đã đánh giá SKPH của bạn là nghiêm trọng', [
                    'title' =>  $this->troubleshoot->descriptionTitle,
                    'approver' =>  $this->troubleshoot->evaluater->name,
                ]);
                break;
            case 'normally':
                $text = __(':title, :approver đã đánh giá SKPH của bạn là không nghiêm trọng', [
                    'title' =>  $this->troubleshoot->descriptionTitle,
                    'approver' =>  $this->troubleshoot->evaluater->name,
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
