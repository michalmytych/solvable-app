<?php

namespace App\Services\Websockets;

use App\Events\UpdateSolutionStateAtClients;
use App\Models\Execution;

class BroadcastingService
{
    /**
     * Broadcast state of currently processed solution test.
     *
     * @param Execution $execution
     */
    public function broadcastExecutionState(Execution $execution): void
    {
        broadcast(new UpdateSolutionStateAtClients($execution));
    }
}
