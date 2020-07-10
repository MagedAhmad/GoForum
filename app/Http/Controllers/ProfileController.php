<?php

namespace App\Http\Controllers;


use App\User;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function show(User $user){
    	return view('profiles.show',[
    		'profileUser' => $user,
    		'activities' => \App\Activity::feed($user)
    	]);
	}
	
	public function updateProfile(User $user) 
	{
		return view('profiles.update', compact('user'));
	}

	public function update(Request $request)
	{
		$this->validate($request, [
            'name' => ['required', 'string', 'max:255'],
		]);
		auth()->user()->update(['name' => $request->name]);
		
		return redirect('/profiles/' . auth()->user()->name);
	}
}
