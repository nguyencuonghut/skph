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
        $url = url('/descriptions/'.$this->prevention->id);
        $toName = '';
        switch ($this->action) {
            case 'assigned_proposer':
                $text = __(':title, :username giao cho bạn đề xuất biện pháp phòng ngừa', [
                    'title' =>  $this->prevention->descriptionTitle,
                    'username' =>  Auth()->user()->name,
                ]);
                $toName = $this->prevention->proposer->name;
                break;
            case 'request_to_approve':
                $text = __(':title, :username yêu cầu bạn phê duyệt biện pháp phòng ngừa', [
                    'title' =>  $this->prevention->descriptionTitle,
                    'username' =>  Auth()->user()->name,
                ]);
                $toName = $this->prevention->approver->name;
                break;
            case 'request_to_approve_root_cause':
                $text = __(':title, :username yêu cầu bạn phê duyệt nguyên nhân gốc rễ', [
                    'title' =>  $this->prevention->descriptionTitle,
                    'username' =>  Auth()->user()->name,
                ]);
                $toName = $this->prevention->root_cause_approver->name;
                break;
            case 'approved_prevention':
                $text = __(':title, :approver đã phê duyệt biện pháp phòng ngừa của bạn', [
                    'approver' =>  $this->prevention->approver->name,
                    'title' =>  $this->prevention->descriptionTitle,
                ]);
                $toName = $this->prevention->proposer->name;
                break;
            case 'rejected_prevention':
                $text = __(':title, :approver đã từ chối biện pháp phòng ngừa của bạn', [
                    'approver' =>  $this->prevention->approver->name,
                    'title' =>  $this->prevention->descriptionTitle,
                ]);
                $toName = $this->prevention->proposer->name;
                break;
            case 'approved_root_cause':
                $text = __(':title, :approver đã đồng ý nguyên nhân gốc rễ của bạn', [
                    'approver' =>  $this->prevention->root_cause_approver->name,
                    'title' =>  $this->prevention->descriptionTitle,
                ]);
                $toName = $this->prevention->proposer->name;
                break;
            case 'rejected_root_cause':
                $text = __(':title, :approver đã từ chối nguyên nhân gốc rễ của bạn', [
                    'approver' =>  $this->prevention->root_cause_approver->name,
                    'title' =>  $this->prevention->descriptionTitle,
                ]);
                $toName = $this->prevention->proposer->name;
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
            case 'assigned_proposer':
                $text = __(':title, :username giao cho bạn đề xuất biện pháp phòng ngừa', [
                    'title' =>  $this->prevention->descriptionTitle,
                    'username' =>  Auth()->user()->name,
                    ]);
                break;
            case 'request_to_approve':
                $text = __(':title, :username yêu cầu bạn phê duyệt biện pháp phòng ngừa', [
                    'title' =>  $this->prevention->descriptionTitle,
                    'username' =>  Auth()->user()->name,
                ]);
                break;
            case 'request_to_approve_root_cause':
                $text = __(':title, :username yêu cầu bạn phê duyệt nguyên nhân gốc rễ', [
                    'title' =>  $this->prevention->descriptionTitle,
                    'username' =>  Auth()->user()->name,
                ]);
                break;
            case 'approved_prevention':
                $text = __(':title, :approver đã phê duyệt biện pháp phòng ngừa của bạn', [
                    'approver' =>  $this->prevention->approver->name,
                    'title' =>  $this->prevention->descriptionTitle,
                ]);
                break;
            case 'rejected_prevention':
                $text = __(':title, :approver đã từ chối biện pháp phòng ngừa của bạn', [
                    'approver' =>  $this->prevention->approver->name,
                    'title' =>  $this->prevention->descriptionTitle,
                ]);
                break;
            case 'approved_root_cause':
                $text = __(':title, :approver đã đồng ý nguyên nhân gốc rễ của bạn', [
                    'approver' =>  $this->prevention->root_cause_approver->name,
                    'title' =>  $this->prevention->descriptionTitle,
                ]);
                break;
            case 'rejected_root_cause':
                $text = __(':title, :approver đã từ chối nguyên nhân gốc rễ của bạn', [
                    'approver' =>  $this->prevention->approver->name,
                    'title' =>  $this->prevention->descriptionTitle,
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
