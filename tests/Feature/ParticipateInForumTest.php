<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ParticipateInForumTest extends TestCase
{
    
    use DatabaseMigrations;

    protected $thread;

    public function setUp(){
        parent::setUp();

        $this->thread = create('App\Thread');
    }

    /** @test */
    public function test_an_unauthenticated_user_may_not_participate_in_forum()
    {
        $this->expectException('Illuminate\Auth\AuthenticationException');
        

        $this->post($this->thread->path(). '/replies', []);

    }
        

    public function test_an_authenticated_user_may_participate_in_forum()
    {
        $this->signIn();


        $reply = make('App\Reply');
        
        $response = $this->post($this->thread->path().'/replies', $reply->toArray());

        $this->get($this->thread->path())
            ->assertSee($reply->body);


    }


    /** @test */
    public function test_a_reply_must_have_a_body()
    {
        $this->withExceptionHandling();
        $this->signIn();
        $reply = make('App\Reply',['body' => null]);
        $this->post($this->thread->path(). '/replies', $reply->toArray())
            ->assertSessionHasErrors('body');
    }
        

}
