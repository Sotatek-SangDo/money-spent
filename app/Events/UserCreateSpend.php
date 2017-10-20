<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use App\User;

class UserCreateSpend implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $spend;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($spend)
    {
        $this->spend = $spend;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new Channel('messagelive');
    }

    public function broadcastWith()
    {
        $user = User::find($this->spend->user_id);
        return [
            'id' => $this->spend->id,
            'user_id' => $this->spend->user_id,
            'title' => $this->spend->title,
            'amount' => $this->spend->amount,
            'name' => $user['name'],
            'is_new' => $this->spend->is_new
        ];
    }
}
