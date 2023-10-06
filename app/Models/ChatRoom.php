<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChatRoom extends Model
{
    use HasFactory;

    public function chirp(){
        $this->hasOne(Chirp::class, 'chat_room_id', 'id');
    }
}
