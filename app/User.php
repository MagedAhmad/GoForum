<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'avatar_path'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];



    public function getRouteKeyName(){
        return 'name';
    }

    public function threads(){
        return $this->hasMany('App\Thread');
    }

    public function activity(){
        return $this->hasMany('App\Activity');
    }


    public function lastReply() {
        return $this->hasOne(Reply::class)->latest();    
    }


    public function read($thread) {

        $key = sprintf("users.%s.visits.%s", auth()->id(), $thread->id);
        
        cache()->forever($key, Carbon::now());
            
    }
    

    public function getAvatarPathAttribute($avatar) {
        if(!$avatar) return asset('storage/avatars/default.png');
        return asset('storage/' . $avatar ?: 'storage/avatars/default.png');
    }

    
    
}
