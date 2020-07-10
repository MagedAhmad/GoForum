<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class LockThreadsTest extends TestCase
{
    use DatabaseMigrations;

    // public function test_non_administrators_and_non_thread_owners_cannot_lock_a_thread()
    // {
    //     $this->withExceptionHandling();

    //     $user = $this->signIn();

    //     $thread = create('App\Thread');

    //     $this->post(route('lock-threads.store', $thread))
    //         ->assertStatus(403);
        
    //     $this->assertFalse($thread->lock);
    // }

    public function test_administrators_can_lock_a_thread()
    {
        $this->withExceptionHandling();
        
        $this->signIn(create('App\User', ['email' => 'maged.ahmedr@gmail.com']));

        $thread = create('App\Thread');

        $this->post(route('lock-threads.store', $thread));

        $this->assertTrue($thread->fresh()->lock);
    }

    public function test_administrators_can_unlock_a_thread()
    {
        
        $this->signIn(create('App\User', ['email' => 'maged.ahmedr@gmail.com']));

        $thread = create('App\Thread', ['lock' => true]);

        $this->delete(route('lock-threads.destroy', $thread));
        
        $this->assertFalse($thread->fresh()->lock);

    }


    public function test_a_locked_thread_cannot_accept_new_replies()
    {
        $this->signIn();

        $thread = create('App\Thread');

        $thread->update(['lock' => true]);

        $this->post($thread->path(). '/replies',[
            'body' => 'something',
            'user_id' => auth()->id()
        ])->assertStatus(422);
    }
}
