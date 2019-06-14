<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ReputationTest extends TestCase
{
    use RefreshDatabase;


    public function test_user_reputation_increases_when_they_create_thread()
    {

        $thread = create('App\Thread');

        $this->assertEquals(5, $thread->user->reputation);
    }

    public function test_user_reputation_decreases_when_thread_is_deleted()
    {
        $this->signIn();

        $thread = create('App\Thread', ['user_id' => auth()->id()]);

        $this->assertEquals(5, $thread->user->reputation);

        $this->delete($thread->path());

        $this->assertEquals(0, $thread->user->fresh()->reputation);
    }

    public function test_user_reputation_increases_when_leaving_a_reply()
    {

        $reply = create('App\Reply');


        $this->assertEquals(2, $reply->user->reputation);
    }

    public function test_user_reputation_decreases_when_reply_is_deleted()
    {
        $this->signIn();

        $reply = create('App\Reply', ['user_id' => auth()->id()]);

        $this->assertEquals(2, $reply->user->reputation);

        $this->delete('/replies/'. $reply->id);

        $reply->delete();

        $this->assertEquals(0, auth()->user()->fresh()->reputation);


    }

    public function test_user_reputation_increases_when_marked_as_best_reply()
    {


        $reply = create('App\Reply', ['user_id' => create('App\User')->id]);

        $reply->thread->markBestReply($reply);


        $this->assertEquals(52, $reply->user->reputation);
    }
}
