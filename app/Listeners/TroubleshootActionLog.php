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
                $text = __(':title was created by :creator and assigned to :assignee', [
                        'title' => $event->getTroubleshoot()->title,
                        'creator' => $event->getTroubleshoot()->user->name,
                        'assignee' => $event->getTroubleshoot()->troubleshooter->name
                    ]);
                break;
            case 'assigned_troubleshooter':
                $text = __(':username assigned troubleshoot to :assignee', [
                        'username' => Auth()->user()->name,
                        'assignee' => $event->getTroubleshoot()->troubleshooter->name
                    ]);
                break;
            case 'approve_request':
                $text = __(':username request :assignee to approve the troubleshoot action', [
                    'username' => Auth()->user()->name,
                    'assignee' => $event->getTroubleshoot()->approver->name
                ]);
                break;
            case 'approved':
                $text = __(':assignee approved your troubleshoot action', [
                    'username' => Auth()->user()->name,
                    'assignee' => $event->getTroubleshoot()->approver->name
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
