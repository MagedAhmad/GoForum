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

        $this->withExceptionHandling();

        $reply = make('App\Reply');
        
        $this->post($this->thread->path().'/replies', $reply->toArray());

        $this->get($this->thread->path());
        $this->assertDatabaseHas('replies', ['body' => $reply->body]);


    }



    /** @test */
    public function test_a_reply_must_have_a_body()
    {
        $this->withExceptionHandling();
        $this->signIn();
        $reply = make('App\Reply',['body' => null]);
        $this->json('post', $this->thread->path(). '/replies', $reply->toArray())
            ->assertStatus(422);
    }
    
    
    public function test_unauthorized_users_cannot_delete_reply()
    {
        $this->withExceptionHandling();
        $reply = create('App\Reply');

        $this->delete('/replies/'. $reply->id)
            ->assertRedirect('/login');

        $this->signIn();

        $this->delete('/replies/'. $reply->id)
            ->assertStatus(403);
        
    }

    public function test_authorized_user_can_delete_his_reply() 
    {
        $this->signIn();
        $reply = create('App\Reply', ['user_id' => auth()->id()]);

        $this->deleteJson('/replies/'. $reply->id);

        $this->assertDatabaseMissing('replies', ['body' => $reply->body]);


    }


    public function test_authorized_user_can_update_reply() 
    {
        $this->signIn();
        $reply = create('App\Reply', ['user_id' => auth()->id()]);

        $updatedReply = 'You changed!';
        $this->patch('/replies/'. $reply->id, ['body' => $updatedReply ]);
        
        $this->assertDatabaseHas('replies', ['id' => $reply->id, 'body' => $updatedReply]);
    }


    public function test_unauthorized_users_cannot_update_reply()
    {
        $this->withExceptionHandling();
        $reply = create('App\Reply');

        $this->patch('/replies/'. $reply->id)
            ->assertRedirect('/login');

        $this->signIn();

        $this->patch('/replies/'. $reply->id)
            ->assertStatus(403);
        
    }

    /** @test */
    public function test_replies_that_contain_spam_may_not_be_created()
    {
        $this->withExceptionHandling();

        $this->SignIn();

        $reply = create('App\Reply',['body' => 'Yahoo customer service']);



        $this->json('post', $this->thread->path().'/replies', $reply->toArray())
            ->assertStatus(422);
        
    }

    /** @test */
    public function test_user_can_reply_once_per_minute()
    {
        $this->withExceptionHandling();

        $this->signIn();

        $reply = create('App\Reply',['body' => 'something good']);

        $this->post($this->thread->path().'/replies', $reply->toArray())
            ->assertStatus(201);

        $this->json('post',$this->thread->path().'/replies', $reply->toArray())
            ->assertStatus(429);

    }


}
