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
    Route::get('/lti/response', 'LTI\responseController@index');
    Route::get('/dashboard/{userId}', 'UserDashboardController@index');
});  

/* Admin Routes */

Route::group(['middleware' => ['web','auth', 'checkAdmin']], function () {
    Route::get('/admin', 'Admin\AdminController@index');   
    Route::get('/admin/settings', 'Admin\SettingsEditController@edit');   
    Route::patch('/admin/settings', 'Admin\SettingsEditController@update');  
    Route::get('/admin/user-register', 'Admin\UserRegistrationController@create');
    Route::post('/admin/user-register', 'Admin\UserRegistrationController@store');
    Route::get('/admin/users', 'Admin\UserManagementController@index');
    Route::get('/admin/user/{userId}', 'Admin\UserEditController@edit');
    Route::patch('/admin/user/{userId}', ['as' => 'user.update', 'uses' =>'Admin\UserEditController@update']);
    Route::get('/admin/tags', 'Admin\TagManagementController@index');
    Route::get('/admin/tag', 'Admin\TagCreateController@create');
    Route::post('/admin/tag', 'Admin\TagCreateController@store');
    Route::get('/admin/tag/{tagId}', 'Admin\TagEditController@edit');
    Route::patch('/admin/tag/{tagId}', ['as' => 'tag.update', 'uses' =>'Admin\TagEditController@update']);
});

Route::group(['middleware' => ['lti']], function () {
    Route::post('/lti/auth', 'LTI\ProviderController@store');
});



