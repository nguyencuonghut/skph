<?php

namespace App\Listeners;

use App\Events\DescriptionAction;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Models\Activity;
use Lang;
use App\Models\Description;

class DescriptionActionLog
{
    /**
     * Create the event listener.
     *
     */
    public function __construct()
    {
    }

    /**
     * Handle the event.
     *
     * @param  DescriptionAction  $event
     * @return void
     */
    public function handle(DescriptionAction $event)
    {
        switch ($event->getAction()) {
            case 'created':
                $text = __(':title được tạo bởi :creator và giao cho :assignee', [
                        'title' => $event->getDescription()->title,
                        'creator' => $event->getDescription()->user->name,
                        'assignee' => $event->getDescription()->leader->name
                    ]);
                break;
            case 'leader_approved':
                $text = __(':title được xác nhận bởi :leader', [
                    'title' => $event->getDescription()->title,
                    'leader' => $event->getDescription()->leader->name
                ]);
                break;
            case 'leader_rejected':
                $text = __(':title bị từ chối xác nhận bởi :leader', [
                    'title' => $event->getDescription()->title,
                    'leader' => $event->getDescription()->leader->name
                ]);
                break;
            case 'effectiveness_asset':
                $text = __('Ticket được đánh giá hiệu quả bởi :username', [
                    'username' => Auth()->user()->name,
                ]);
                break;
            case 'updated_status':
                $text = __('Ticket được đánh dấu hoàn thành bởi :username', [
                        'username' => Auth()->user()->name,
                    ]);
                break;
            case 'updated_time':
                $text = __(':username inserted a new time for this ticket', [
                        'username' => Auth()->user()->name,
                    ]);
                ;
                break;
            case 'updated_assign':
                $text = __(':username assigned ticket to :assignee', [
                        'username' => Auth()->user()->name,
                        'assignee' => $event->getDescription()->user->name
                    ]);
                break;
            default:
                break;
        }

        $activityinput = array_merge(
            [
                'text' => $text,
                'user_id' => Auth()->id(),
                'source_type' =>  Description::class,
                'source_id' =>  $event->getDescription()->id,
                'action' => $event->getAction()
            ]
        );
        
        Activity::create($activityinput);
    }
}
