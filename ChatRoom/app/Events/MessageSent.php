<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class MessageSent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $message;
    public  $room_id;
    public function __construct($message,$room_id)
    {
        $this->message = $message;
        $this->room_id = $room_id;

    }

    public function broadcastOn()
    {
        return ['my-channel_'.$this->room_id];
    }

    public function broadcastAs()
    {
        return 'my-event';
    }
}
