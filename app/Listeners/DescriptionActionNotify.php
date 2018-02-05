<?php

namespace App\Listeners;

use App\Events\DescriptionAction;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Notifications\DescriptionActionNotification;

class DescriptionActionNotify
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
     * @param  TaskAction  $event
     * @return void
     */
    public function handle(DescriptionAction $event)
    {
        $description = $event->getDescription();
        $action = $event->getAction();
        $description->assignedUser->notify(new DescriptionActionNotification(
            $description,
            $action
        ));
    }
}
