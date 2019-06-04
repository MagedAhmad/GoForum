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
    
    /** @test */
    public function test_wraps_mentioned_users_in_body_within_anchor_tags()
    {
        $reply = create('App\Reply', ['body' => 'Hello @test']);


        $this->assertEquals(
            'Hello <a href="/profiles/test">@test</a>',
            $reply->body
        );
        
    }


    public function test_reply_knows_if_its_the_best_reply()
    {
        $reply = create('App\Reply');
        
        $this->assertFalse($reply->isBest());

        $reply->thread->update(['best_reply_id' => $reply->id]);

        $this->assertTrue($reply->isBest());


    }
        
        
        
}
