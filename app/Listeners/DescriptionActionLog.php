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
                $text = __(':title was created by :creator and assigned to :assignee', [
                        'title' => $event->getDescription()->title,
                        'creator' => $event->getDescription()->user->name,
                        'assignee' => $event->getDescription()->user->name
                    ]);
                break;
            case 'updated_status':
                $text = __('Task was completed by :username', [
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
