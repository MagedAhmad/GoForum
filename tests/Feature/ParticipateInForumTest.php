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

        $this->get($this->thread->path());
        $this->assertDatabaseHas('replies', ['body' => $reply->body]);


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

        $this->delete('/replies/'. $reply->id)
            ->assertStatus(302);
        
        $this->assertDatabaseMissing('replies', $reply->toArray());


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

}
