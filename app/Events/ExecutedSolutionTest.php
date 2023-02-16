<?php

namespace App\Events;

use App\Models\User;
use App\Models\Execution;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class ExecutedSolutionTest implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     */
    public function __construct(public Execution $execution, public User $user)
    {
    }

    /**
     * Get the channels the event should broadcast on.
     */
    public function broadcastOn(): array
    {
        return [
            'solution-tests-executions-updates' // . $this->user->getRememberToken() @todo - implement
        ];
    }

    public function broadcastAs(): string
    {
        return 'executed-new-solution-test';
    }
}
