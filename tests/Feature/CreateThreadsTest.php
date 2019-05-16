<?php

namespace Tests\Feature;


use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class CreateThreadsTest extends TestCase
{
    use DatabaseMigrations;

        

    /** @test */
    public function test_guests_cannot_create_new_forum_threads()
    {

       $this->withExceptionHandling();

        $this->get('/threads/create')
            ->assertRedirect('/login');

        $this->post('/threads')
            ->assertRedirect('/login');

    }
        


    /** @test */
    public function test_an_authenticated_user_can_create_new_forum_thread()
    {
        $this->signIn();
        $thread = make('App\Thread');
        $response = $this->post('/threads',$thread->toArray());
        $this->get($response->headers->get('Location'))
            ->assertSee($thread->title)
            ->assertSee($thread->body);
    }

    /** @test */
    public function test_a_thread_requires_a_title()
    {

        $this->publishThread(['title' => null])
            ->assertSessionHasErrors('title');
    }

    /** @test */
    public function test_a_thread_requires_a_body()
    {

        $this->publishThread(['body' => null])
            ->assertSessionHasErrors('body');
    }


    /** @test */
    public function test_a_thread_requires_a_valid_channel_id()
    {
        $thread = create('App\Thread');
        $this->publishThread(['channel_id' => null])
            ->assertSessionHasErrors('channel_id');

        $this->publishThread(['channel_id' => 999])
            ->assertSessionHasErrors('channel_id');
    }

    public function publishThread($overrides = []){
        
        $this->withExceptionHandling();
        $this->signIn();
        $thread = make('App\Thread',$overrides);
        return $this->post('/threads', $thread->toArray());
    }

        

    /** @test */
    public function test_authorized_user_can_delete_thread()
    {
        $this->withExceptionHandling();
        $this->signIn();

        $thread = create('App\Thread', ['user_id' => auth()->id()]);
        $reply = create('App\Reply',['thread_id' => $thread->id]);

        $this->json('DELETE', $thread->path());

        $this->assertDatabaseMissing('threads', ['id' => $thread->id]);
        $this->assertDatabaseMissing('replies', ['id' => $reply->id]);

        $this->assertEquals(0, \App\Activity::count());


    }

    /** @test */
    public function test_unauthorized_users_cannot_delete_thread()
    {
        $this->withExceptionHandling();
        
        $this->signIn();
        $thread = create('App\Thread');
        $this->json('DELETE', $thread->path());
        $this->assertDatabaseHas('threads', ['id' => $thread->id]);

    }
        
        
        
        
}
