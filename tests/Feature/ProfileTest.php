<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ProfileTest extends TestCase
{
    use DatabaseMigrations;

    
    /** @test */
    public function test_a_user_has_a_profile()
    {
        
        $user = create('App\User');

        $this->get("/profiles/{$user->name}")
        	->assertSee($user->name);

    }


    /** @test */
    public function test_user_profile_shows_threads_related_to_user()
    {

        $this->signIn();

        $thread = create('App\Thread',['user_id' => auth()->user()->id]);
        $this->get("/profiles/" . auth()->user()->name)
        	->assertSee($thread->title)
        	->assertSee($thread->body);

    }
        
        

    
        
        
        
}
	