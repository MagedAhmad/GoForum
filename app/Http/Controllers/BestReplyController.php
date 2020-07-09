<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Reply;

class BestReplyController extends Controller
{
    public function store(Reply $reply) {
        $this->authorize('update', $reply->thread);

        $reply->thread->markBestReply($reply);
        // $reply->thread->update(['best_reply_id' => $reply->id]);
    }
}
