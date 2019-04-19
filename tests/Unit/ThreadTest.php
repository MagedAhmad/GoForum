<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ThreadTest extends TestCase
{
    use DatabaseMigrations;

    protected $thread;

	public function setUp(){
		parent::setUp();

		$this->thread = create('App\Thread');
	}


    /** @test */
    public function test_a_thread_has_replies()
    {
        $this->assertInstanceOf('Illuminate\Database\Eloquent\Collection', $this->thread->replies);
    }
        
    /** @test */
    public function test_a_thread_has_an_owner()
    {
        $this->assertInstanceOf('App\User', $this->thread->user);
    }
        
    /** @test */
    public function test_a_thread_can_add_a_reply()
    {
        $this->thread->addReply([
        	'body' => 'blah blah',
        	'user_id' => 1,
        ]);

        $this->assertCount(1,$this->thread->replies);
    }


    /** @test */
    public function test_a_thread_belongs_to_a_channel()
    {
        $thread = create('App\Thread');
        $this->assertInstanceOf('App\Channel', $thread->channel);
    }


    /** @test */
    public function test_a_thread_can_make_a_string_path()
    {
        $thread = create('App\Thread');

        $this->assertEquals('/threads/'. $thread->channel->name. '/'. $thread->id, $thread->path());
    }


    public function test_a_thread_can_be_subscribed() {
        
        // given we have a thread
        $thread = create('App\Thread');

        // and a signed in user
        $this->signIn();
        // when he subscribes to the thread
        $thread->subscripe();

        // we can fetch all subscribed threads

        $this->assertEquals(1,
            $thread->subscriptions()->where(['user_id' => auth()->id()])->count());

    }


    public function test_a_thread_can_be_unsubscribed() {
        
        // given we have a thread
        $thread = create('App\Thread');

        // and a signed in user
        $this->signIn();
        // when he subscribes to the thread
        $thread->subscripe();

        // we can fetch all subscribed threads

        $this->assertEquals(1,
            $thread->subscriptions()->count());

        $thread->unsubscripe();
        $this->assertEquals(0,
            $thread->subscriptions()->count());

    }


    public function test_a_thread_can_return_if_auth_user_subscriped_to_it() {
        $thread = create('App\Thread');

        $this->signIn();


        $this->AssertFalse($thread->isSub());


        $thread->subscripe();

        $this->AssertTrue($thread->isSub());

    }
    
    
        
        
}
