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
                $text = __('<b><i> :title </i></b> được tạo bởi :creator và giao cho :assignee', [
                        'title' => $event->getDescription()->title,
                        'creator' => $event->getDescription()->user->name,
                        'assignee' => $event->getDescription()->leader->name
                    ]);
                break;
            case 'leader_approved':
                $text = __('<b><i> :title </i></b> được <b style="color:blue"><i>đồng ý</i></b> xác nhận bởi :leader', [
                    'title' => $event->getDescription()->title,
                    'leader' => $event->getDescription()->leader->name
                ]);
                break;
            case 'leader_rejected':
                $text = __('<b><i> :title </i></b> bị <b style="color:red"><i>từ chối</i></b> xác nhận bởi :leader', [
                    'title' => $event->getDescription()->title,
                    'leader' => $event->getDescription()->leader->name
                ]);
                break;
            case 'effectiveness_asset':
                $text = __('<b><i> :title </i></b>, được đánh giá <b><i> :effectiveness</b></i> bởi :username', [
                    'title' => $event->getDescription()->title,
                    'username' => Auth()->user()->name,
                    'effectiveness' => $event->getDescription()->effectiveness,
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
