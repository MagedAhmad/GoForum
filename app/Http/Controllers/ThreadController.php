<?php

namespace App\Http\Controllers;

use App\Thread;
use App\Channel;
use Illuminate\Http\Request;
use App\Filters\ThreadFilters;
use App\Rules\SpamFree;


class ThreadController extends Controller
{
    public function __construct(){
        $this->middleware('auth')->except(['show','index']);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Channel $channel,ThreadFilters $filters)
    {
        $threads = $this->getThreads($filters, $channel);

        if(request()->wantsJson()){
            return $threads;
        }

        return view('threads.index',[
            'threads' => $threads,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('threads.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request,[
            'title' => ['required', new SpamFree],
            'body' => 'required',
            'channel_id' => 'required|exists:channels,id',
        ]); 

        $thread = Thread::create([
            'user_id' => auth()->id(),
            'channel_id' => request('channel_id'),
            'title' => request('title'),
            'body' => request('body'),
            'slug' => request('title')
        ]);

        return redirect($thread->path())
        ->with('flash', 'Thread created successfully');
    }


    public function show($channel, Thread $thread)
    {
        if(auth()->check()){
            auth()->user()->read($thread);
        }
        
        return view('threads.show', compact('thread'));
    }


    public function update($channel, Thread $thread)
    {

        $this->authorize('update', $thread);

        $thread->update(request()->validate([
            'title' => 'required',
            'body' => 'required'
        ]));

    }

    public function destroy($channel, Thread $thread)
    {
        if($this->authorize('update', $thread)){
            $thread->delete();
            return redirect('/threads');
        }

        return redirect('/login');
    }



    public function getThreads($filters, $channel){
        $threads = Thread::filter($filters)->latest();

        if($channel->exists) {
            $threads = $threads->where(['channel_id' => $channel->id]);
        }
        
        return $threads->paginate(25);
    }
}
