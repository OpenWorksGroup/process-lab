<?php

/*
|--------------------------------------------------------------------------
| Routes File
|--------------------------------------------------------------------------
|
| Here is where you will register all of the routes in an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/


/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| This route group applies the "web" middleware group to every route
| it contains. The "web" middleware group is defined in your HTTP
| kernel and includes session state, CSRF protection, and more.
|
*/


/*Route::get('/user-router', ['middleware' => 'userRouter', function () {
}]);*/

Route::group(['middleware' => ['web']], function () {
    Route::auth();
    Route::get('/start',  'AdminController@start');
    Route::get('/',  'HomeController@index');
});  

/* Admin Routes */

Route::group(['middleware' => ['web','auth', 'checkAdmin']], function () {
    Route::get('/admin/dashboard', 'AdminController@index');   
    Route::get('/admin/register-user', 'AdminController@userRegistrationCreate');
    Route::post('/admin/register-user', 'AdminController@userRegistrationStore');
});



