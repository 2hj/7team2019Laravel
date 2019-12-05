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

Route::get('/', 'MainController@index')->name('Mainpage');

Route::resource('/japan', 'JapanController');

Route::resource('/members', 'MembersController');

Route::resource('/qna', 'QnAController');

Route::get('ajax', 'AjaxController@index');

/* Social Login */
Route::get('social/{provider}', [
    'as' => 'social.login',
    'uses' => 'SocialController@execute',
]);


Route::post('/register', "MembersController@test");

// Route::post('/members/{$id}', 'MembersController@ajaxteset');

Route::post('/ajaxtest', "MembersController@ajaxtest");

Route::post('/createMember', "MembersController@createMember");

// Route::post('/addMember', "MembersController@test");
