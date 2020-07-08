<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UpdateThreadsTest extends TestCase
{
    use RefreshDatabase;

    public function test_unauthorized_user_cannot_update_thread()
    {
        $this->withExceptionHandling();
        $this->signIn();

        $thread = create('App\Thread', ['user_id' => create('App\User')->id]);

        $this->patch($thread->path(), [])
            ->assertStatus(403);
        
    }

    public function test_title_and_body_are_required_to_update_thread()
    {
        $this->withExceptionHandling();

        $this->signIn();
        
        $thread = create('App\Thread',['user_id' => auth()->id()]);

        $this->patch($thread->path(), [
            'title' => 'changed',
        ])->assertSessionHasErrors('body');

        $this->patch($thread->path(), [
            'body' => 'changed',
        ])->assertSessionHasErrors('title');
    }

    public function test_a_thread_can_be_updated()
    {
        $this->signIn();
        
        $thread = create('App\Thread',['user_id' => auth()->id()]);

        $this->patch($thread->path(), [
            'title' => 'changed',
            'body' => 'changed body'
        ]);

        $this->assertEquals('changed', $thread->fresh()->title);
        $this->assertEquals('changed body', $thread->fresh()->body);
    }
}
