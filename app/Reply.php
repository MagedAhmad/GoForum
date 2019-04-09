<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Reply extends Model
{
    use Favoritable, RecordsActivity;

	protected $guarded = [];

    protected $with = ['user', 'favorites'];
	
    protected $appends  = [ 'favoritesCount', 'isFavorited', 'can_update'];


    protected static function boot(){
        parent::boot();
        

        static::created(function($reply){
            $reply->thread->increment('replies_count');
            
        });

        static::deleted(function($reply){
            $reply->thread->decrement('replies_count');
            
        });
        
    }


    public function user(){
    	return $this->belongsTo('App\User');
    }


    public function thread(){
    	return $this->belongsTo('App\Thread');
    }

    public function path(){
        return $this->thread->path() . "#reply-" .$this->id;
    }

    public function getCanUpdateAttribute()
    {
        return \Gate::allows('update', $this);
    }


}
