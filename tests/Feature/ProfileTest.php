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
        $user = create('App\User');
        
        $thread = create('App\Thread',['user_id' => $user->id]);
        $this->get("/profiles/{$user->name}")
        	->assertSee($thread->title)
        	->assertSee($thread->body);

    }
        
        

    
        
        
        
}
	