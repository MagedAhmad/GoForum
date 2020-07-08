<?php 



namespace App;


trait Favoritable {

    protected static function bootFavoritable() {
        static::deleting(function($model) {
            $model->favorites->each->delete();
        });  
    }
    

    public function favorites(){
    	return $this->morphMany('App\Favorite', 'favorited');
    }


    public function favorite(){
    	if(!$this->favorites()->where(['user_id' => auth()->user()->id])->exists()){
	        $this->favorites()->create(['user_id'=> auth()->user()->id]);
    	}
    }

    public function unfavorite(){
        $attributes = ['user_id' => auth()->id()];

        $this->favorites()->where($attributes)->get()->each->delete();
        
    }

    public function isFavorited(){
        if(auth()->check()){
            return !! $this->favorites->count();
        }
    }

    public function getIsFavoritedAttribute() {
        return $this->isFavorited();
    }
    

    public function getFavoritesCountAttribute(){
        return $this->favorites->count();
    }


}