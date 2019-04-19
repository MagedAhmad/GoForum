<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Thread;
use App\ThreadSubscription;


class ThreadSubscriptionController extends Controller
{

	public function __construct() {
		return $this->middleware('auth');	
	}
	

    public function store($channelId, Thread $thread) {
    	ThreadSubscription::create([
    		'user_id' => auth()->id(),
    		'thread_id' => $thread->id
    	]);



    }


    public function destroy($channelId, Thread $thread) {
        ThreadSubscription::where([
            'thread_id' => $thread->id, 
            'user_id' => auth()->id()])
        ->delete();        
    }
    
    
}
