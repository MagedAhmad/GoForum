<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class MentionUsersTest extends TestCase
{
    use DatabaseMigrations;


    public function test_user_can_mention_other_users()
    {
        $JohnDoe = create('App\User');

        $this->signIn($JohnDoe);

        $JaneDoe = create('App\User', ['name' => 'JaneDoe']);

        $thread = create('App\Thread');
        $reply = create('App\Reply', [
            'body' => '@JaneDoe you are a great man! thanks'
        ]);

        $this->post($thread->path().'/replies', $reply->toArray());


        $this->assertCount(1, $JaneDoe->notifications);

    }
}
