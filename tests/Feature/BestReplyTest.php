<?php

namespace Tests\Feature;


use Tests\TestCase;

use Illuminate\Foundation\Testing\DatabaseMigrations;

class BestReplyTest extends TestCase
{
    use DatabaseMigrations;

  
    public function test_a_reply_can_be_marked_as_best_reply() {


        $this->signIn();

        $thread = create('App\Thread', ['user_id' => auth()->id()]);
    
        $replies = create('App\Reply',['thread_id' => $thread->id],3);

        $this->assertFalse($replies[1]->fresh()->isBest());

        
        $this->postJson(route('best-replies.store', [$replies[1]->id]));
        
        $this->assertTrue($replies[1]->fresh()->isBest());

    }



    public function test_only_thread_creators_can_mark_reply_as_best()
    {
        $this->withExceptionHandling();

        $this->signIn();

        $thread = create('App\Thread', ['user_id' => auth()->id()]);

        $replies = create('App\Reply',['thread_id' => $thread->id],3);

        $this->signIn(create('App\User'));

        $this->postJson(route('best-replies.store', [$replies[1]->id]));

        $this->assertFalse($replies[1]->fresh()->isBest());


    }
    


    public function test_delete_best_reply_from_threads_table_when_the_reply_is_deleted()
    {
        
        $this->signIn();

        $reply = create('App\Reply', ['user_id' => auth()->id()]);

        $reply->thread->markBestReply($reply);

        $this->deleteJson(route('replies.destroy', $reply));

        $this->assertNull($reply->thread->fresh()->best_reply_id);
    }
        
        
        
}