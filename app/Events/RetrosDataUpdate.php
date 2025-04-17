<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use App\Models\RetrosData;
class RetrosDataUpdate implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $data;
    public $retro_id;
    public $column_id;

    public function __construct(RetrosData $data , $retro_id)
    {
        $this->retro_id = $retro_id;
        $this->data = $data;
        $this->column_id = $data->column_id;
    }

    public function broadcastOn()
    {
        return new Channel('retro-card.' .$this->retro_id); 
    }

    public function broadcastAs()
    {
        return 'retros-data-updated';
    }

    public function broadcastWith()
    {
        return [
            'data' => [
                'id' => $this->data->id,
                'name' => $this->data->name,
                'column_id' => $this->data->column_id
            ]
        ];
    }
}