<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class NewMessage implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public string $message;
    public int $id;

    public function __construct( $message , $id = 0)
    {
        $this->id = $id;
        $this->message = $message;
    }

    public function broadcastOn(): Channel
    {
        return new Channel('chat'); // hier der Channel-Name
    }

    public function broadcastAs(): string
    {
        return 'new.message'; // hier der Event-Name im Frontend, können auch mehrere Events pro Channel geben!
    }
}
