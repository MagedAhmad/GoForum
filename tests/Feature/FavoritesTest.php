<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class FavoritesTest extends TestCase
{
    use DatabaseMigrations;

    	
    /** @test */
    public function test_guests_cannot_favorite_anything()
    {
        $this->withExceptionHandling();

    	$this->post('/replies/1/favorites')
    		->assertRedirect('/login');
    }
        
    /** @test */
    public function test_an_authenticated_user_can_favorite_replies()
    {
        $this->withExceptionHandling();

        $this->signIn();

    	$reply = create('App\Reply'); 

    	$this->post('/replies/'. $reply->id . '/favorites');
    	
    	$this->assertCount(1, $reply->favorites);
        
    }

    public function test_user_can_favorite_reply_only_once(){
        $this->signIn();
    	$reply = create('App\Reply'); 
    	$this->post('/replies/'. $reply->id . '/favorites');
    	$this->post('/replies/'. $reply->id . '/favorites');

    	$this->assertCount(1, $reply->favorites);
        
    	
    }
        

    
        
        
        
}
	