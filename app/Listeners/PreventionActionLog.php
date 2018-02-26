<?php

namespace App\Listeners;

use App\Events\PreventionAction;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Models\Activity;
use Lang;
use App\Models\Prevention;

class PreventionActionLog
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
     * @param  PreventionAction  $event
     * @return void
     */
    public function handle(PreventionAction $event)
    {
        switch ($event->getAction()) {
            case 'assigned_proposer':
                $text = __(':username giao cho :assignee đề xuất biện pháp phòng ngừa', [
                        'username' => Auth()->user()->name,
                        'assignee' => $event->getPrevention()->proposer->name
                    ]);
                break;
            case 'request_to_approve':
                $text = __(':username yêu cầu :assignee phê duyệt biện pháp phòng ngừa', [
                    'username' => Auth()->user()->name,
                    'assignee' => $event->getPrevention()->approver->name
                ]);
                break;
            case 'request_to_approve_root_cause':
                $text = __(':username yêu cầu :assignee phê duyệt nguyên nhân gốc rễ', [
                    'username' => Auth()->user()->name,
                    'assignee' => $event->getPrevention()->root_cause_approver->name
                ]);
                break;
            case 'approved_prevention':
                $text = __(':assignee đã phê duyệt biện pháp phòng ngừa', [
                    'username' => Auth()->user()->name,
                    'assignee' => $event->getPrevention()->approver->name
                ]);
                break;
            case 'rejected_prevention':
                $text = __(':assignee đã bị từ chối biện pháp phòng ngừa', [
                    'username' => Auth()->user()->name,
                    'assignee' => $event->getPrevention()->approver->name
                ]);
                break;
            case 'approved_root_cause':
                $text = __(':assignee đã đồng ý nguyên nhân gốc rễ', [
                    'username' => Auth()->user()->name,
                    'assignee' => $event->getPrevention()->root_cause_approver->name
                ]);
                break;
            case 'rejected_root_cause':
                $text = __(':assignee đã từ chối nguyên nhân gốc rễ', [
                    'username' => Auth()->user()->name,
                    'assignee' => $event->getPrevention()->root_cause_approver->name
                ]);
                break;
            default:
                break;
        }

        $activityinput = array_merge(
            [
                'text' => $text,
                'user_id' => Auth()->id(),
                'source_type' =>  Prevention::class,
                'source_id' =>  $event->getPrevention()->id,
                'action' => $event->getAction()
            ]
        );
        
        Activity::create($activityinput);
    }
}
