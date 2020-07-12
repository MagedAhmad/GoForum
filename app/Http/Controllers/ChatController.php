<?php

namespace App\Http\Controllers;

use App\Events\MessageSent;
use App\Message;
use App\User;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    public function __construct()
    {
        return $this->middleware('auth');
    }

    public function show(User $recipient)
    {
        return view('chats', compact('recipient'));
    }

    public function messages(User $recipient)
    {
        $messages = Message::where([
            ['recipient_id' , $recipient->id], 
            ['sender_id' , auth()->user()->id]
        ])->orWhere([
            ['sender_id' , $recipient->id], 
            ['recipient_id' , auth()->user()->id]
        ])->with('user')->get();
        
        return $messages;
    }

    public function store(Request $request)
    {
        $recipient = User::find($request->to);
        $message = Message::create([
            'recipient_id' => $recipient->id,
            'sender_id' => auth()->user()->id,
            'body' => $request->body
        ]);
        
        broadcast(new MessageSent($message->load('user'), $recipient))->toOthers();
    }

}           
