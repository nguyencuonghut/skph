<?php

namespace App\Listeners;

use App\Events\TroubleshootAction;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Models\Activity;
use Lang;
use App\Models\Troubleshoot;

class TroubleshootActionLog
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
     * @param  TroubleshootAction  $event
     * @return void
     */
    public function handle(TroubleshootAction $event)
    {
        switch ($event->getAction()) {
            case 'created':
                $text = __('<b><i>:title</i></b> được tạo bởi :creator và giao cho :assignee', [
                        'title' => $event->getTroubleshoot()->title,
                        'creator' => $event->getTroubleshoot()->user->name,
                        'assignee' => $event->getTroubleshoot()->troubleshooter->name
                    ]);
                break;
            case 'assigned_troubleshooter':
                $text = __('<b><i>:title</i></b>, :username giao cho :assignee xử lý', [
                        'title' => $event->getTroubleshoot()->descriptionTitle,
                        'username' => Auth()->user()->name,
                        'assignee' => $event->getTroubleshoot()->troubleshooter->name
                    ]);
                break;
            case 'request_to_approve':
                $text = __('<b><i>:title</i></b>, :username yêu cầu :assignee phê duyệt biện pháp khắc phục', [
                    'title' => $event->getTroubleshoot()->descriptionTitle,
                    'username' => Auth()->user()->name,
                    'assignee' => $event->getTroubleshoot()->approver->name
                ]);
                break;
            case 'approved':
                $text = __('<b><i>:title</i></b>, :assignee đã <b><i style="color:blue">đồng ý</i></b> biện pháp khắc phục', [
                    'title' => $event->getTroubleshoot()->descriptionTitle,
                    'username' => Auth()->user()->name,
                    'assignee' => $event->getTroubleshoot()->approver->name
                ]);
                break;
            case 'rejected':
                $text = __('<b><i>:title</i></b>, :assignee đã <b><i style="color:red">từ chối</i></b> biện pháp khắc phục', [
                    'title' => $event->getTroubleshoot()->descriptionTitle,
                    'username' => Auth()->user()->name,
                    'assignee' => $event->getTroubleshoot()->approver->name
                ]);
                break;
            case 'seriously':
                $text = __('<b><i>:title</i></b>, :username đã đánh giá SKPH là <b><i style="color:red">nghiêm trọng</i></b>', [
                    'title' => $event->getTroubleshoot()->descriptionTitle,
                    'username' => Auth()->user()->name
                ]);
                break;
            case 'normally':
                $text = __('<b><i>:title</i></b>, :username đã đánh giá SKPH là <b><i style="color:blue">không nghiêm trọng</i></b>', [
                    'title' => $event->getTroubleshoot()->descriptionTitle,
                    'username' => Auth()->user()->name
                ]);
                break;
            default:
                break;
        }

        $activityinput = array_merge(
            [
                'text' => $text,
                'user_id' => Auth()->id(),
                'source_type' =>  Troubleshoot::class,
                'source_id' =>  $event->getTroubleshoot()->id,
                'action' => $event->getAction()
            ]
        );
        
        Activity::create($activityinput);
    }
}
