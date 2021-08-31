<?php

namespace App\Events;

use App\Models\Execution;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class UpdateSolutionStateAtClients implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Data to be broadcast with the event.
     *
     * @var Execution
     */
    public Execution $broadcastData;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Execution $execution)
    {
        $this->broadcastData = $execution;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return Channel
     */
    public function broadcastOn(): Channel
    {
        return new Channel('channel');
    }
}
