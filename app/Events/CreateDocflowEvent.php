<?php

namespace App\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;


class CreateDocflowEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;


    public $cadastralNumber;
    public function __construct($cadastralNumber)
    {
        $this->cadastralNumber = $cadastralNumber;
    }
    
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}

