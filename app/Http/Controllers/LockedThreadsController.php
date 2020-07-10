<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Thread;

class LockedThreadsController extends Controller
{
    public function store(Thread $thread)
    {   
        if(auth()->user()->isAdmin || auth()->user()->id == $thread->user->id) {
            $thread->update(['lock' => true]);
        }else {
            return 403;
        }

    }


    public function destroy(Thread $thread)
    {

        $thread->update(['lock' => false]);
    }
}
