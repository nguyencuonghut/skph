<?php

namespace App\Providers;

use Illuminate\Contracts\Events\Dispatcher as DispatcherContract;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        'App\Events\ClientAction' => [
            'App\Listeners\ClientActionNotify',
            'App\Listeners\ClientActionLog',
        ],
         'App\Events\TaskAction' => [
            'App\Listeners\TaskActionNotify',
            'App\Listeners\TaskActionLog',
         ],
        'App\Events\DescriptionAction' => [
            'App\Listeners\DescriptionActionNotify',
            'App\Listeners\DescriptionActionLog',
        ],
        'App\Events\TroubleshootAction' => [
            'App\Listeners\TroubleshootActionNotify',
            'App\Listeners\TroubleshootActionLog',
        ],
        'App\Events\PreventionAction' => [
            'App\Listeners\PreventionActionNotify',
            'App\Listeners\PreventionActionLog',
        ],
        'App\Events\LeadAction' => [
            'App\Listeners\LeadActionNotify',
            'App\Listeners\LeadActionLog',
        ],
        'App\Events\NewComment' => [
            'App\Listeners\NotiftyMentionedUsers'
        ]
    ];

    /**
     * Register any other events for your application.
     *
     * @internal param DispatcherContract $events
     */
    public function boot()
    {
        parent::boot();

        //
    }
}
