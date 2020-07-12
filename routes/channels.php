<?php

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

// use App\User;

// Broadcast::channel('App.User.{id}', function ($user, $id) {
//     return (int) $user->id === (int) $id;
// });

// Broadcast::channel('chat.{recipient}', function ($user, User $recipient) {
//     return $user->id !== $user->recipient;
// });

use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('chat', function ($user) {

    return true;
});
