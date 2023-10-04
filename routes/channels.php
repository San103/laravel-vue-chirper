<?php

use App\Events\UsersComment;
use App\Models\Chirp;
use App\Models\User;
use Illuminate\Support\Facades\Broadcast;

/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
|
| Here you may register all of the event broadcasting channels that your
| application supports. The given channel authorization callbacks are
| used to check if an authenticated user can listen to the channel.
|
*/
// Broadcast::channel('my-channel', function ($user, $message) {
//     broadcast(new UsersComment($user, $message))->toOthers();
//     // return true;
// });
Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});
