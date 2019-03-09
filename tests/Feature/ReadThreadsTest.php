<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ReadThreadsTest extends TestCase
{
    use DatabaseMigrations;


    public function setUp(){
        parent::setUp();
        $this->thread = create('App\Thread');
    }
    /** @test */
    public function test_a_user_can_browse_all_threads()
    {

        $response = $this->get('/threads');

        $response->assertSee($this->thread->title);
    }


    /** @test */
    public function test_a_user_can_browse_single_thread()
    {

        $response = $this->get($this->thread->path())
                            ->assertSee($this->thread->title);
    }


    /** @test */
    public function test_a_user_can_read_replies_associated_to_thread()
    {

        $reply = create('App\Reply',['thread_id' => $this->thread->id]);
        $this->get($this->thread->path())
            ->assertSee($reply->body);
    }
        

    /** @test */
    public function test_user_can_filter_threads_by_channel()
    {
        $channel = create('App\Channel');
        $threadInChannel = create('App\Thread',['channel_id' => $channel->id]);
        $threadNotInChannel = create('App\Thread');
        $this->get('/threads/'. $channel->slug)
            ->assertSee($threadInChannel->title)
            ->assertDontSee($threadNotInChannel->title);
    }
    
    

    public function test_user_can_filter_threads_by_any_username(){
        $this->signIn(create('App\User',['name' => 'MagedRaslan']));

        $threadByMaged = create('App\Thread',['user_id' => auth()->user()->id]);
        $threadNotByMaged = create('App\Thread');

        $this->get('/threads?by=MagedRaslan')
            ->assertSee($threadByMaged->title)
            ->assertDontSee($threadNotByMaged->title);
    }


    /** @test */
    public function test_a_user_can_filter_threads_by_popularity()
    {
        // we get 3 threads . one with 3 replies one with 2 replies and one with 0 replies
        // when we visit /threads?popular=1
        // we get them in order

        $threadWithTwoReplies = create('App\Thread');
        create('App\Reply',['thread_id' => $threadWithTwoReplies],2);

        $threadWithThreeReplies = create('App\Thread');
        create('App\Reply',['thread_id' => $threadWithThreeReplies],3);

        $threadWithNoReply = $this->thread;



        $response = $this->getJson('/threads?popular=1')->json();

        $this->assertEquals([3,2,0], array_column($response, 'replies_count'));
    }
        

}
   