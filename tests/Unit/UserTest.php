<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class UserTest extends TestCase
{
	
	use DatabaseMigrations;
	
    /** @test */
    public function test_user_return_last_reply()
    {
    	$user = create('App\User');
    	$reply = create('App\Reply', ['user_id' => $user->id]);

    	$this->assertEquals($reply->id, $user->lastReply->id);

    }
    
    
        
}
