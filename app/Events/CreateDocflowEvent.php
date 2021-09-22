<?php

namespace App\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Bus\Queueable;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;


class CreateDocflowEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $id;
    public $cadastralNumber;
    public function __construct($cadastralNumber, $id)
    {
        $this->id = $id;
        $this->cadastralNumber = $cadastralNumber;
    }
    
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}

