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

        $threadWithTwoReplies = create('App\Thread');
        create('App\Reply',['thread_id' => $threadWithTwoReplies],2);

        $threadWithThreeReplies = create('App\Thread');
        create('App\Reply',['thread_id' => $threadWithThreeReplies],3);

        $threadWithNoReply = $this->thread;



        $response = $this->getJson('/threads?popular=1')->json();
        $this->assertEquals([3,2,0], array_column($response['data'], 'replies_count'));
    }


    public function test_a_user_can_request_all_replies_for_a_given_thread() {
        $thread = create('App\Thread');
        create('App\Reply',['thread_id' => $thread->id],3);

        $response = $this->getJson($thread->path().'/replies')->json();

        $this->assertEquals(3, $response['total']);

    }


    public function test_user_can_filter_by_unanswered_threads() {
        $thread = create('App\Thread');
        $reply = create('App\Reply', ['thread_id' => $thread->id]);

        $response = $this->getJson('/threads?unanswered=1')->json();

        $this->assertCount(1, $response['data']);
    }
    
    
        

}
   