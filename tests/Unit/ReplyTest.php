<?php

namespace Tests\Unit;

use Carbon\Carbon;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class ReplyTest extends TestCase
{
	
	use DatabaseMigrations;
	
    /** @test */
    public function test_reply_has_owner()
    {
        $reply = create('App\Reply');

        $this->assertInstanceOf('App\User', $reply->user);
    }


    public function test_reply_can_get_if_it_was_just_published() {

    	$reply = create('App\Reply');

    	$this->assertTrue($reply->wasJustPublished());

    	$reply = create('App\Reply', ['created_at' => Carbon::now()->subMonth()]);

    	$this->assertFalse($reply->wasJustPublished());
    }
    

    
        
        
}
