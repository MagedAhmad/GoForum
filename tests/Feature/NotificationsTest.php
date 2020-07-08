<?php

namespace Tests\Feature;

use Tests\TestCase;

use Illuminate\Foundation\Testing\DatabaseMigrations;

class NotificationsTest extends TestCase
{
    
    use DatabaseMigrations;


    public function test_notification_is_ready_when_reply_is_left() {

        $this->signIn();

        $thread = create('App\Thread')->subscripe();

        $thread->addReply([
            'body' => 'something',
            'user_id' => auth()->id(),
        ]);

        $this->assertCount(0, auth()->user()->notifications);

        $thread->addReply([
            'body' => 'something',
            'user_id' => create('App\User')->id,
        ]);

        $this->assertCount(1, auth()->user()->fresh()->notifications);

    }



    public function test_user_can_mark_a_notification_as_read() {
        $this->signIn();

        $thread = create('App\Thread')->subscripe();

        $thread->addReply([
            'body' => 'something',
            'user_id' => create('App\User')->id,
        ]); 

        $this->assertCount(1, auth()->user()->unreadNotifications);

        $notificationId = auth()->user()->unreadNotifications->first()->id;

        $this->delete("/profiles/" . auth()->user()->name . "/notifications/" . $notificationId);

        $this->assertCount(0, auth()->user()->fresh()->unreadNotifications);

    }


    public function test_user_can_fetch_all_unread_notifications() {
        $this->signIn();

        $thread = create('App\Thread')->subscripe();

        $thread->addReply([
            'body' => 'something',
            'user_id' => create('App\User')->id,
        ]); 

        $response = $this->getJson("/profiles/" . auth()->user()->name . "/notifications")->json();
        
        $this->assertCount(1, $response);

    }
    
    
    
}
