<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use App\Models\Troubleshoot;

class TroubleshootAction
{
    private $troubleshoot;
    private $action;

    use InteractsWithSockets, SerializesModels;

    public function getTroubleshoot()
    {
        return $this->troubleshoot;
    }
    public function getAction()
    {
        return $this->action;
    }

    /**
     * Create a new event instance.
     * DescriptionAction constructor.
     * @param Troubleshoot $troubleshoot
     * @param $action
     */
    public function __construct(Troubleshoot $troubleshoot, $action)
    {
        $this->troubleshoot = $troubleshoot;
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
