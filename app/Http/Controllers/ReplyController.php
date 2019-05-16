<?php

namespace App\Http\Controllers;



use App\Reply;
use App\Rules\SpamFree;
use App\Thread;
use Illuminate\Http\Request;

class ReplyController extends Controller
{
    
    public function __construct(){
        $this->middleware('auth',['except' => 'index']);
    }



    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($channelId, Thread $thread)   
    {
        return $thread->replies()->paginate(10);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     */
    public function store($channelId, Thread $thread)
    {

        try {
            $this->authorize('create', new Reply);

            $this->validate(request(),['body' => ['required', new SpamFree]]);

            $reply = $thread->addReply([
                'body' => request('body'),
                'user_id' => auth()->id(),
            ]);
        }catch(\Exception $e) {
            return response('Your reply couldnot be saved at this time!', 422);
        }
        
        return $reply->load('user');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Reply  $reply
     * @return \Illuminate\Http\Response
     */
    public function show(Reply $reply)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Reply  $reply
     * @return \Illuminate\Http\Response
     */
    public function edit(Reply $reply)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Reply  $reply
     * @return \Illuminate\Http\Response
     */
    public function update(Reply $reply)
    {
        try {
            $this->authorize('update', $reply);

            $reply->update(request(['body']));
    
        }catch(\Exception $e) {
            return response('Your reply couldnot be saved at this time!', 422);
        } 
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Reply  $reply
     * @return \Illuminate\Http\Response
     */
    public function destroy(Reply $reply)
    {
        $this->authorize('update', $reply);
        if(request()->expectsJson()) {
            $reply->delete();
            return response(['status' => 'deleted successfully']);
        }
        return back();

    }

  
}
