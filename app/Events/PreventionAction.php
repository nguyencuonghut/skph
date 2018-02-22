<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use App\Models\Prevention;

class PreventionAction
{
    private $prevention;
    private $action;

    use InteractsWithSockets, SerializesModels;

    public function getPrevention()
    {
        return $this->prevention;
    }
    public function getAction()
    {
        return $this->action;
    }

    /**
     * Create a new event instance.
     * PreventionAction constructor.
     * @param Prevention $prevention
     * @param $action
     */
    public function __construct(Prevention $prevention, $action)
    {
        $this->prevention = $prevention;
        $this->action = $action;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
