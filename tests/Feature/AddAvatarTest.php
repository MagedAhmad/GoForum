<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class AddAvatarTest extends TestCase
{
	
	use DatabaseMigrations;
	
    /** @test */
    public function test_only_members_can_add_avatars()
    {
        $this->withExceptionHandling();

    	$this->json('post', 'api/users/1/avatar')
    		->assertStatus(401);    
    }

    /** @test */
    public function test_a_valid_avatar_must_be_provided()
    {
    	$this->withExceptionHandling();
    	$this->signIn();
    	$this->json('post', 'api/users/1/avatar', [
    		'avatar' => 'not-valid-avatar'
    	])->assertStatus(422);    
    }

    /** @test */
    public function test_a_user_may_Add_avatar_to_their_profile()
    {

    	$this->signIn();

    	$this->json('post', 'api/users/'. auth()->id(). '/avatar', [
    		'avatar' => $file = UploadedFile::fake()->image('avatar.jpg')
    	]);

    	$this->assertEquals(asset('storage/avatars/' . $file->hashName()), auth()->user()->avatar_path);

    	Storage::disk('public')->assertExists('avatars/'. $file->hashName());
    	
    }
    
        
        
}
