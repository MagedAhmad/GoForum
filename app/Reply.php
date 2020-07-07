<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Reply extends Model
{
    use Favoritable, RecordsActivity;

	protected $guarded = [];

    protected $with = ['user', 'favorites'];
	
    protected $appends  = [ 'favoritesCount', 'isFavorited', 'can_update', 'isBest'];


    protected static function boot(){
        parent::boot();
        

        static::created(function($reply){
            $reply->thread->increment('replies_count');

            (new Reputation)->award($reply->user, 'created_reply');
        });

        static::deleted(function($reply){
            $reply->thread->decrement('replies_count');
            (new Reputation)->reduce($reply->user, 'created_reply');

        });
        
    }


    public function user(){
    	return $this->belongsTo('App\User');
    }


    public function thread(){
    	return $this->belongsTo('App\Thread');
    }



    /**
     * Set the body attribute.
     *
     * @param string $body
     */
    public function setBodyAttribute($body)
    {
        $this->attributes['body'] = preg_replace(
            '/@([\w\-]+)/',
            '<a href="/profiles/$1">$0</a>',
            $body
        );
    }
    

    public function path(){
        return $this->thread->path() . "#reply-" .$this->id;
    }

    public function getCanUpdateAttribute()
    {
        return \Gate::allows('update', $this);
    }


    public function wasJustPublished() {
        return $this->created_at->gt(Carbon::now()->subMinute());    
    }
    

    public function isBest() {
        return $this->thread->best_reply_id == $this->id;
    }

    public function getIsBestAttribute()
    {
        return $this->isBest();
    }

}
