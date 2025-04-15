<?php

namespace App\Events;

use App\Models\RetrosColumns;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class RetrosColumnCreated implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $column;

    public function __construct(RetrosColumns $column)
    {
        $this->column = $column;
    }

    public function broadcastOn()
    {
        return new Channel('retro.' . $this->column->retro_id);
    }

    public function broadcastAs(){
        return 'retros-column-created';
    }

    public function broadcastWith()
    {
        return [
            'id' => $this->column->id,
            'name' => $this->column->name,
        ];
    }
}
