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


Route::post('/lti/auth', 'LTI\ProviderController@store');

Route::group(['middleware' => ['web']], function () {
    Route::auth();
    Route::get('/start',  'Admin\StartController@index');
    Route::get('/',  'HomeController@index');
    Route::get('/typography', 'TypographyController@index');
    Route::get('/lti/response', 'LTI\responseController@index');
    Route::get('/dashboard/{userId}', 'UserDashboardController@index');
    Route::get('/api/content-tags', 'API\ContentTagsController@index');
    Route::post('/api/content-tags', 'API\ContentTagsController@store');
    Route::delete('/api/content-tags', 'API\ContentTagsController@destroy');
});  

/* Admin Routes */

Route::group(['middleware' => ['web','auth', 'checkAdmin']], function () {
    Route::get('/admin', 'Admin\AdminController@index');   
    Route::get('/admin/settings', 'Admin\SettingsController@edit');   
    Route::patch('/admin/settings', 'Admin\SettingsController@update');  
    Route::get('/api/admin/settings', 'Admin\API\SettingsController@index');
    Route::post('/api/admin/template-rubric', 'Admin\API\TemplateRubricController@store');
    Route::delete('/api/admin/template-rubric', 'Admin\API\TemplateRubricController@destroy');

    Route::get('/admin/users', 'Admin\UserController@index');
    Route::get('/admin/users/create', 'Admin\UserController@create');
    Route::post('/admin/users', 'Admin\UserController@store');
    Route::get('/admin/users/{userId}', 'Admin\UserController@edit');
    Route::patch('/admin/users/{userId}', ['as' => 'users.update', 'uses' =>'Admin\UserController@update']);

    Route::get('/admin/templates', 'Admin\TemplateController@index');
    Route::get('/admin/templates/create', 'Admin\TemplateController@create');
    Route::post('/admin/templates', 'Admin\TemplateController@store');
    Route::get('/admin/template/{templateId}', 'Admin\TemplateController@edit');
    Route::patch('/admin/templates/{templateId}', ['as' => 'templates.update', 'uses' => 'Admin\TemplateController@update']);

    Route::get('/admin/tags', 'Admin\TagController@index');
    Route::get('/admin/tags/create', 'Admin\TagController@create');
    Route::post('/admin/tags', 'Admin\TagController@store');
   // Route::delete('/admin/tags/{tagId}', 'Admin\TagController@delete');
    Route::get('/admin/tags/{tagId}', 'Admin\TagController@edit');
    Route::patch('/admin/tags/{tagId}', ['as' => 'tags.update', 'uses' =>'Admin\TagController@update']);

    Route::post('/admin/templates/course', 'Admin\TemplateCourseController@store');

    Route::post('/admin/templates/section', 'Admin\TemplateSectionController@store');

    Route::post('/admin/templates/section-field', 'Admin\TemplateSectionFieldController@store');

    Route::get('/admin/competency-frameworks', 'Admin\CompetencyFrameworkController@index');
    Route::get('/admin/competency-frameworks/retrieve', 'Admin\CompetencyFrameworkController@retrieve');
    Route::get('/admin/competency-framework/create', 'Admin\CompetencyFrameworkController@create');
    Route::post('/admin/competency-framework', 'Admin\CompetencyFrameworkController@store');
    Route::post('/admin/competency-framework-category', 'Admin\CompetencyFrameworkCategoryController@store');
    Route::get('/admin/competency-framework/{cfId}', 'Admin\CompetencyFrameworkController@edit');

    Route::get('/admin/competency-frameworks/retrieve', 'Admin\CompetencyFrameworkController@retrieve');
    Route::get('/admin/competency-frameworks-categories/retrieve', 'Admin\CompetencyFrameworkCategoryController@retrieve');

});