<?php

namespace App\Services\Websockets;

use App\Models\Execution;
use App\Events\UpdateSolutionStateAtClients;

class BroadcastingService
{
    /**
     * Broadcast state of currently processed solution test.
     *
     * @param Execution $execution
     */
    public function broadcastExecutionState(Execution $execution): void
    {
        UpdateSolutionStateAtClients::dispatch($execution);
    }
}
