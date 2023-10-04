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
// Broadcast::routes(['middleware' => ['auth:sanctum']]);

Broadcast::channel('chat.{roomId}', function (User $user, int $roomId) {
    // if ($user->canJoinRoom($roomId)) {
        return ['id' => $user->id, 'name' => $user->name];
    // }
    // return true;
});

Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});
