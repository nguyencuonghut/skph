<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use App\Models\Description;

class DescriptionAction
{
    private $description;
    private $action;

    use InteractsWithSockets, SerializesModels;

    public function getDescription()
    {
        return $this->description;
    }
    public function getAction()
    {
        return $this->action;
    }

    /**
     * Create a new event instance.
     * DescriptionAction constructor.
     * @param Description $description
     * @param $action
     */
    public function __construct(Description $description, $action)
    {
        $this->description = $description;
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
