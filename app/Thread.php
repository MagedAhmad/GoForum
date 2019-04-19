<?php

namespace App;


use App\Activity;
use App\Notifications\ThreadWasUpdated;


use Illuminate\Database\Eloquent\Model;

class Thread extends Model
{

    use RecordsActivity;

	protected $guarded = [];
    
    protected $with = ['channel', 'user'];


    protected $appends = ['isSubscripedTo'];

    protected static function boot(){
        parent::boot();
        

        static::deleting(function($thread){
            $thread->replies->each->delete();
            
        });
        
    }


    public function path(){
    	return '/threads/'. $this->channel->name . '/' .$this->id ;
    }


    public function replies(){
    	return $this->hasMany('App\Reply');
    }

    public function user(){
    	return $this->belongsTo('App\User');
    }

    public function addReply($reply){
    	$reply = $this->replies()->create($reply);

        foreach($this->subscriptions as $subscription) {
            if($subscription->user->id != $reply->user_id) {
                $subscription->user->notify(new ThreadWasUpdated($this, $reply));
            }
        }

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
    

}
