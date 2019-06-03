<?php 



namespace App;

use Illuminate\Support\Facades\Redis;

use App\Thread;

class Trending {


	public function cachekey() {

	    return app()->environment('testing') ?  'test_trending_threads' : 'trening_threads';
	
	}

	public function get() {
        return array_map('json_decode', Redis::zrevrange($this->cachekey(), 0, 4));
	}



	public function push(Thread $thread) {
	    Redis::zincrby($this->cachekey(), 1, json_encode([
            'title' => $thread->title,
            'path' => $thread->path()
        ]));
	}


	public function reset() {
   		Redis::del('test_trending_threads');
	}


} 