<?php

namespace App;


use App\Notifications\ThreadWasUpdated;
use App\Providers\ThreadReceivedNewReply;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

use App\Reputation;


class Thread extends Model
{

    use RecordsActivity, RecordsVisits;

	protected $guarded = [];
    
    protected $with = ['channel', 'user'];

    protected $casts = ['lock' => 'boolean'];

    protected $appends = ['isSubscripedTo'];

    protected static function boot(){
        parent::boot();
        

        static::deleting(function($thread){
            $thread->replies->each->delete();
            (new Reputation)->reduce($thread->user, 'created_thread');

            
        });

        static::created(function($thread) {
            (new Reputation)->award($thread->user, 'created_thread');

        });
        
    }


    public function path(){
    	return '/threads/'. $this->channel->name . '/' . $this->slug ;
    }


    public function replies(){
    	return $this->hasMany('App\Reply');
    }

    public function user(){
    	return $this->belongsTo('App\User');
    }

    public function addReply($reply){

    	$reply = $this->replies()->create($reply);
        
        event(new ThreadReceivedNewReply($reply));

        return $reply;

    }


    public function channel(){
        return $this->belongsTo('App\Channel');
    }

    public function scopeFilter($query, $filters){
        return $filters->apply($query);
    }



    public function subscripe() {

        $this->subscriptions()->create([
            'user_id' => auth()->id()
        ]);


        return $this;

    }


    public function unsubscripe() {
        $this->subscriptions()->where(['user_id' => auth()->id()])->delete();
    }
    
    

    public function subscriptions() {
        return $this->hasMany(ThreadSubscription::class);
    }

    public function getIsSubscripedToAttribute()
    {
        return $this->subscriptions()
            ->where(['user_id' => auth()->id()])
            ->exists();
    }

    

    public function isSub() {
        return $this->subscriptions()
            ->where(['user_id' => auth()->id()])
            ->exists();    
    }
    


    public function hasUpdatesFor() {
        $key = sprintf("users.%s.visits.%s", auth()->id(), $this->id);
        return $this->updated_at > cache($key);
    }
    

    public function getRouteKeyName(){
        return 'slug';
    }

    public function setSlugAttribute($value) {
        if(static::whereSlug($slug = Str::slug($value))->exists()){
            $slug = $this->incrementSlug($slug);
        }

        $this->attributes['slug'] = $slug;
    }


    public function incrementSlug($slug) {
        
        $original = $slug;
        $count = 2;

        while(static::whereSlug($slug)->exists()) {
            $slug = "{$original}-" . $count++;
        }

        return $slug;

    }



    public function markBestReply(Reply $reply)
    {
        (new Reputation)->award($reply->user, 'best_reply');

        $this->update(['best_reply_id' => $reply->id]);
    }

}
