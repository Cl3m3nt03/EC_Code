<?php

namespace App\Events;

use App\Models\RetrosData;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class CardMoovUpdate implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $data;
    public $old_column_id;
    public $retro_id;

    /**
     * Create a new event instance.
     */
    public function __construct(RetrosData $data, $old_column_id, $retro_id)
    {
        $this->data = $data;
        $this->old_column_id = $old_column_id;
        $this->retro_id = $retro_id;
    }

    public function broadcastAs()
    {
        return 'card-move-update';
    }

    public function broadcastOn(): array
    {
        return [
            new Channel('retro.' . $this->retro_id)
        ];
    }

    public function broadcastWith(): array
    {
        return [
            'id' => $this->data->id,
            'name' => $this->data->name,
            'column_id' => $this->data->column_id,
            'old_column_id' => $this->old_column_id,
            'user_id' => $this->data->user_id,
        ];
    }
}
