<?php

namespace App\Events;

use Illuminate\Support\Str;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class SentGeneralNotification implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public string $id;

    public string $notification;

    /**
     * Create a new event instance.
     */
    public function __construct(string $notification)
    {
        $this->notification = $notification;
        $this->id = (string) Str::uuid();
    }

    /**
     * Get the channels the event should broadcast on.
     */
    public function broadcastOn(): array
    {
        return [
            'general-notifications'
        ];
    }

    public function broadcastAs(): string
    {
        return 'sent-general-notification';
    }
}
