<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Reply extends Model
{
	protected $guarded = [];

	
    public function user(){
    	return $this->belongsTo('App\User');
    }


    public function favorites(){
    	return $this->morphMany('App\Favorite', 'favorited');
    }


    public function favorite(){
    	if(!$this->favorites()->where(['user_id' => auth()->user()->id])->exists()){
	        $this->favorites()->create(['user_id'=> auth()->user()->id]);
    	}
    }

    public function isFavorited(){
        return $this->favorites()->where(['user_id' => auth()->user()->id])->exists();
    }
}
