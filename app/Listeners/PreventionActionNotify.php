<?php

namespace App\Listeners;

use App\Events\PreventionAction;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Notifications\PreventionActionNotification;

class PreventionActionNotify
{
    /**
     * Create the event listener.
     *
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  PreventionAction  $event
     * @return void
     */
    public function handle(PreventionAction $event)
    {
        $prevention = $event->getPrevention();
        $action = $event->getAction();
        switch ($event->getAction()) {
            case 'assigned_proposer':
                $prevention->assignedUser->notify(new PreventionActionNotification(
                    $prevention,
                    $action
                ));
                break;
            case 'request_to_approve':
                $prevention->approvedUser->notify(new PreventionActionNotification(
                    $prevention,
                    $action
                ));
                break;
            case 'approved':
                $prevention->assignedUser->notify(new PreventionActionNotification(
                    $prevention,
                    $action
                ));
                break;
            default:
                $prevention->assignedUser->notify(new PreventionActionNotification(
                    $prevention,
                    $action
                ));
                break;
        }
    }
}
