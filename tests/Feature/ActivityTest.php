<?php

namespace Tests\Feature;


use App\Activity;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ActivityTest extends TestCase
{
    use DatabaseMigrations;

    
    public function test_record_activity_when_thread_is_created(){
    	
        $this->signIn();
    	
    	$thread = create('App\Thread');

    	$this->assertDatabaseHas('activities', [
    		'user_id' => auth()->id(),
    		'type' => 'created_thread',
    		'subject_id' => $thread->id,
    		'subject_type' => 'App\Thread'
    	]);
        $activity = Activity::first();
        $this->assertEquals($activity->subject->id, $thread->id);
    }


    /** @test */
    public function test_record_activity_When_reply_is_created()
    {
        $this->signIn();
        
        $reply = create('App\Reply');

        $this->assertEquals(2, Activity::count());
    }
        

    
        
        
        
}