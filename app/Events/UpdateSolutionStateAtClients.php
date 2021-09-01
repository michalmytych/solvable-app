<?php

namespace App\Events;

use App\Models\Execution;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;

class UpdateSolutionStateAtClients implements ShouldBroadcastNow
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
     * @return PrivateChannel
     */
    public function broadcastOn(): PrivateChannel
    {
        return new PrivateChannel('solution-state-updates');
    }
}
