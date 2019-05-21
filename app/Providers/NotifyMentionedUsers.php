<?php

namespace App\Providers;

use App\Notifications\YouWereMentioned;
use App\Providers\ThreadReceivedNewReply;
use App\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class NotifyMentionedUsers
{
    

    /**
     * Handle the event.
     *
     * @param  ThreadReceivedNewReply  $event
     * @return void
     */
    public function handle(ThreadReceivedNewReply $event)
    {
        preg_match_all('/\@([^\s\.]+)/', $event->reply->body, $matches);

        $names = $matches[1];

        foreach($names as $name) {
            if($user = User::whereName($name)->first()) {
                $user->notify(new YouWereMentioned($event->reply));
            }
        }
    }
}
