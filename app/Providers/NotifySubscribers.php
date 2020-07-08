<?php

namespace App\Providers;

use App\Notifications\ThreadWasUpdated;
use App\Providers\ThreadReceivedNewReply;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class NotifySubscribers
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  ThreadReceivedNewReply  $event
     * @return void
     */
    public function handle(ThreadReceivedNewReply $event)
    {
        foreach($event->reply->thread->subscriptions as $subscription) {
            if($subscription->user->id != $event->reply->user_id) {
                $subscription->user->notify(new ThreadWasUpdated('App\Thread', $event->reply));
            }
        }
    }
}
