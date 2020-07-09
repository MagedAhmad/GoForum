<?php 


namespace App;

class Reputation {

    protected $points = [
        'created_thread' => 3,
        'created_reply' => 1,
        'best_reply' => 20,
    ];

    public function award($user, $event)
    {
        $user->increment('reputation', $this->points[$event]);
    }

    public function reduce($user, $event)
    {
        $user->decrement('reputation', $this->points[$event]);
    }


}