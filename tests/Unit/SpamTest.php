<?php

namespace Tests\Unit;

use App\Inspections\Spam;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class SpamTest extends TestCase
{
	
	use DatabaseMigrations;
	
    /** @test */
    public function test_it_can_invalid_keywords()
    {

    	$spam = new Spam;

    	$this->assertTrue(!$spam->detect('something good!'));

    	$this->expectException('Exception');

    	$spam->detect('Yahoo customer service'); 

    }

    /** @test */
    public function test_it_can_detect_key_held_down()
    {
        $spam  = new Spam;

        $this->expectException('Exception');

        $spam->detect('ddddddd');

    }
	    
        
        
}