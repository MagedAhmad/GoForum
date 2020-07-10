<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Auth::routes();
Auth::routes(['verify' => true]); 

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/threads','ThreadController@index');
Route::get('/','ThreadController@index');
Route::get('/threads/create','ThreadController@create');
Route::get('/threads/{channel}/{thread}','ThreadController@show');
Route::delete('/threads/{channel}/{thread}','ThreadController@destroy');
Route::patch('/threads/{channel}/{thread}','ThreadController@update');
Route::post('/threads','ThreadController@store');
Route::get('/threads/{channel}', 'ThreadController@index');

Route::post('lock-threads/{thread}', 'LockedThreadsController@store')->name('lock-threads.store');
Route::delete('lock-threads/{thread}', 'LockedThreadsController@destroy')->name('lock-threads.destroy');

Route::post('/replies/{reply}/best', 'BestReplyController@store')->name('best-replies.store');

// threads
Route::post('/threads/{channel}/{thread}/replies', 'ReplyController@store');
Route::get('/threads/{channel}/{thread}/replies', 'ReplyController@index');
Route::patch('/replies/{reply}', 'ReplyController@update');
Route::delete('/replies/{reply}', 'ReplyController@destroy')->name('replies.destroy');

// replies
Route::post('/replies/{reply}/favorites', 'FavoritesController@store');
Route::delete('/replies/{reply}/favorites', 'FavoritesController@destroy');

Route::post('/threads/{channel}/{thread}/subscriptions','ThreadSubscriptionController@store');
Route::delete('/threads/{channel}/{thread}/subscriptions','ThreadSubscriptionController@destroy');

// profiles
Route::get('/profiles/{user}', 'ProfileController@show')->name('profile');
Route::get('/profiles/{user}/update', 'ProfileController@updateProfile');
Route::patch('/profiles/{user}', 'ProfileController@update');
Route::delete('/profiles/{user}/notifications/{notification}', 'UserNotificationsController@destroy');
Route::get('/profiles/{user}/notifications', 'UserNotificationsController@index');

Route::get('api/users', 'Api\UsersController@index');
Route::post('api/users/{user}/avatar', 'Api\UsersAvatarController@store')->middleware('auth')->name('avatar');


// authentication
Route::get('/login/{social}','Auth\LoginController@socialLogin')->where('social','twitter|facebook|linkedin|google|github|bitbucket');
Route::get('/login/{social}/callback','Auth\LoginController@handleProviderCallback')->where('social','twitter|facebook|linkedin|google|github|bitbucket');



