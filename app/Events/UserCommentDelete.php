<?php

namespace App\Events;

use App\Models\Chirp;
use App\Models\User;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class UserCommentDelete implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     */
    public function __construct(public Chirp $message)
    {
        // dd($message);
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {

        // dd($this->message);
        return [
            new PrivateChannel('delete.' . $this->message->chat_room_id),
        ];
    }
    public function broadcastAs()
  {
      return 'delete-event';
  }
  public function broadcastWith(){
    return [
      'user' =>$this->message->id,
      'message' => $this->message->message,
    ];
  }
}
