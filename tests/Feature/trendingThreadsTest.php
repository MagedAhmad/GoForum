<?php

namespace Tests\Feature;


use Tests\TestCase;

use Illuminate\Support\Facades\Redis;

use Illuminate\Foundation\Testing\DatabaseMigrations;

use App\Trending;

class TrendingClassTest extends TestCase
{
    use DatabaseMigrations;

   	protected function setUp() {
   		parent::setUp();

   		$this->trending = new Trending();

   		$this->trending->reset();
   	}


    public function test_it_increment_a_threads_score_each_time_its_visited() {
        
 		$this->assertEmpty(Redis::zrevrange($this->trending->cachekey(), 0, -1));

    	$thread = create('App\Thread');

        $this->get($thread->path());


 		$this->assertCount(1, Redis::zrevrange($this->trending->cachekey(), 0, -1));
    }

    
        
        
        
}