<?php

namespace App\Events;

use App\Models\Message;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Log;

class MessageSent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $message;
    /**
     * Create a new event instance.
     */
    public function __construct(Message $message)
    {
        $this->message = $message;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastAs(): string
    {
        return 'message.sent';
    }
    public function broadcastOn()
    {
        Log::info('Broadcasting on channel: chat.' . $this->message->to_id);
       return new PrivateChannel('chat.' . $this->message->to_id);
    }

     public function broadcastWith(): array
    {
       return [
        'id' => $this->message->id,
        'from_id' => $this->message->from_id,
        'to_id' => $this->message->to_id,
        'message' => $this->message->message,
        'created_at' => $this->message->created_at->diffForHumans(),
        'sender' => $this->message->sender

       ];
    }
}
