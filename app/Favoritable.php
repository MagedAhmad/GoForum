<?php 



namespace App;


trait Favoritable {

    public function favorites(){
    	return $this->morphMany('App\Favorite', 'favorited');
    }


    public function favorite(){
    	if(!$this->favorites()->where(['user_id' => auth()->user()->id])->exists()){
	        $this->favorites()->create(['user_id'=> auth()->user()->id]);
    	}
    }

    public function isFavorited(){
        if(auth()->check()){
            return !! $this->favorites->count();
        }
    }

    public function getFavoritesCountAttribute(){
        return $this->favorites->count();
    }
}