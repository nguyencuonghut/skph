<?php

namespace App\Listeners;

use App\Events\TroubleshootAction;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Notifications\TroubleshootActionNotification;

class TroubleshootActionNotify
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
     * @param  TroubleshootAction  $event
     * @return void
     */
    public function handle(TroubleshootAction $event)
    {
        $troubleshoot = $event->getTroubleshoot();
        $action = $event->getAction();
        switch ($event->getAction()) {
            case 'assigned_troubleshooter':
                $troubleshoot->assignedUser->notify(new TroubleshootActionNotification(
                    $troubleshoot,
                    $action
                ));
                break;
            case 'request_to_approve':
                $troubleshoot->approvedUser->notify(new TroubleshootActionNotification(
                    $troubleshoot,
                    $action
                ));
                break;
            default:
                $troubleshoot->assignedUser->notify(new TroubleshootActionNotification(
                    $troubleshoot,
                    $action
                ));
                break;
        }
    }
}
