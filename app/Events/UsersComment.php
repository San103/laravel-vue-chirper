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
    use Dispatchable, InteractsWithSockets, SerializesModels;

    
    /**
     * Create a new event instance.
     */
    // public $message;
    // public $message;
    public function __construct(public User $user, public Chirp $message)
    {
      // dd($message);
        // $this->dontBroadcastToCurrentUser();
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn()
  {

    return [
      new PresenceChannel('chat.'. $this->message->chat_room_id),
  ];
    // return new Channel('my-channel');
    
    //   return ['my-channel'];
  }

  public function broadcastAs()
  {
      return 'my-event';
  }
  public function broadcastWith(){
    return [
      'user' =>$this->user->name,
      'message_id' =>$this->message->id,
      'message' => $this->message->message,
    ];
  }
}
