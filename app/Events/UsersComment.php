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





class UsersComment implements ShouldBroadcast
{
    use Dispatchable, SerializesModels;

    
    /**
     * Create a new event instance.
     */
    // public $message;
    // public $message;
    public function __construct(public User $user, public Chirp $message)
    {
        // $this->dontBroadcastToCurrentUser();
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn()
  {
    // dd($this->message->room_id);
    return [
      new PresenceChannel('chat.'. $this->message->room_id),
  ];
    // return new Channel('my-channel');
    
    //   return ['my-channel'];
  }

  public function broadcastAs()
  {
      return 'my-event';
  }
}
