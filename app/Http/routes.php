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
    Route::get('/start',  'Admin\StartController@index');
    Route::get('/',  'HomeController@index');
    Route::get('/typography', 'TypographyController@index');
});  

/* Admin Routes */

Route::group(['middleware' => ['web','auth', 'checkAdmin']], function () {
    Route::get('/admin/dashboard', 'Admin\AdminController@index');   
    Route::get('/admin/register-user', 'Admin\UserRegistrationController@index');
    Route::post('/admin/register-user', 'Admin\UserRegistrationController@create');
    Route::get('/admin/manage-users', 'Admin\UserManagementController@index');
    Route::get('/admin/edit-user/{userId}', 'Admin\UserEditController@index');
    Route::post('/admin/edit-user', 'Admin\UserEditController@update');
});



