<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UsersAvatarController extends Controller
{

    public function store() {
    	$this->validate(request(), [
    		'avatar' => ['required', 'image']
    	]);
		
		// if(auth()->user()->avatar_path) {
		// 	unlink(auth()->user()->avatar_path);
		// }

    	auth()->user()->update([
    		'avatar_path' => request()->file('avatar')->store('avatars', 'public')
    	]);

    	return response([], 204);
    }
    
}
