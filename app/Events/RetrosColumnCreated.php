<?php

namespace App\Events;

use App\Models\RetrosColumns;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class RetrosColumnCreated implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $column;
    public $retro;

    public function __construct(RetrosColumns $column , $retro_id)
    {
        $this->column = $column;
        $this->retro = $retro_id;
    }

    public function broadcastOn()
    {
        return new Channel('retro.' .$this->retro );
    }

    public function broadcastAs(){
        return 'retros-column-created';
    }

    public function broadcastWith()
    {
        return [
            'column' => [
                'id' => $this->column->id,
                'name' => $this->column->name,
            ]
        ];
    }
}
