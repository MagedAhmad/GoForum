<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class SubscripteToThreadTest extends TestCase
{
    use DatabaseMigrations;

    public function test_an_auth_user_can_subscripte_to_thread() {
        
        $thread = create('App\Thread');

        $this->signIn();

        $this->assertEquals(0, $thread->subscriptions()->count());


        $this->post($thread->path() . '/subscriptions');

        $this->assertEquals(1, $thread->subscriptions()->count());

    }

    public function test_a_guest_cannot_subscripte_to_thread() {
        
        $this->withExceptionHandling();

        $thread = create('App\Thread');


        $this->post($thread->path() . '/subscriptions')
            ->assertRedirect('login');

    }
    
   

}
   