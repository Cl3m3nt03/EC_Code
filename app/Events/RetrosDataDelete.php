<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use App\Models\RetrosData;

class RetrosDataDelete implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $cardId;
    public $retro_id;
    public $column_id;

    public function __construct(RetrosData $data, $retro_id)
    {
        $this->cardId = $data->id;
        $this->retro_id = $retro_id;
        $this->column_id = $data->column_id;
    }

    public function broadcastOn()
    {
        return new Channel('retro-card.' . $this->retro_id);
    }

    public function broadcastAs()
    {
        return 'retros-data-deleted';
    }

    public function broadcastWith()
    {
        return [
            'data' => [
                'id' => $this->cardId,
                'column_id' => $this->column_id
            ]
        ];
    }
}
