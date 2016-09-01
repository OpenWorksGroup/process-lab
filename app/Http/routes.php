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

/** Status Report */
Route::post('/status-report', 'API\ContentStatusReportController@index');

Route::group(['middleware' => ['web']], function () {
    Route::auth();
    Route::get('/',  'HomeController@index');
    Route::get('/home',  'HomeController@index');
    Route::get('/start',  'Admin\StartController@index');
    Route::get('/lti/response', 'LTI\responseController@index');
    Route::get('/dashboard', 'UserDashboardController@index');
    Route::get('/api/content-tags', 'API\ContentTagsController@index');
    Route::post('/api/content-tags', 'API\ContentTagsController@store');
    Route::delete('/api/content-tags', 'API\ContentTagsController@destroy');
    Route::get('/artifact-rubric/{templateId}',  'Artifact\ArtifactRubricController@index');
});  


/** Artifact Pages  **/
Route::group(['middleware' => ['web','auth']], function () {
    Route::get('/artifact-builder/{templateId}',  'Artifact\BuilderController@index');
    Route::post('/artifact-builder',  'Artifact\BuilderController@store');
    Route::get('/artifact-edit/{contentId}',  'Artifact\BuilderController@edit');
    Route::post('/artifact-edit',  'Artifact\BuilderController@update');
    Route::get('/artifact/{contentId}/{sectionId}', 'Artifact\SectionController@edit');
    Route::post('/artifact/field', 'Artifact\FieldController@store');
    Route::delete('/artifact/field/delete','Artifact\FieldController@destroy');
    Route::get('/artifact-notes/{contentId}', 'Artifact\NotesController@edit');
    Route::post('/artifact-notes', 'Artifact\NotesController@store');
    Route::get('/artifact-tags/{contentId}', 'Artifact\TagsController@edit');
    Route::post('/artifact-feedback-switch', 'Artifact\ContentSectionCommentController@store');
    Route::get('/artifact-collab/{contentId}', 'Artifact\TagsController@index');
    Route::get('/publish-content/{contentId}', 'Artifact\PublishController@store');
    Route::get('/artifact/{contentId}', 'Artifact\PublishController@index');
    Route::get('/artifact-collaboration/{contentId}/{sectionId}', 'Artifact\CollaborationController@edit');
    Route::post('/artifact-collaboration', 'Artifact\CollaborationController@store');
    Route::get('/artifact-collaboration/{contentId}', 'Artifact\CollaborationController@index');
    Route::get('/review/{contentId}', 'Artifact\ReviewController@store');
    Route::get('/submit-review/{contentId}', 'Artifact\ReviewerController@edit');
    Route::post('/submit-review', 'Artifact\ReviewerController@store');
    Route::get('/artifact-reviews/{contentId}', 'Artifact\ReviewController@index');
});

/** Dashboard Pages  **/
Route::group(['middleware' => ['web','auth']], function () {
    Route::get('/build-list', 'Dashboard\BuildListController@index');
});

/* Admin Routes */

Route::group(['middleware' => ['web','auth', 'checkAdmin']], function () {
    Route::get('/admin', 'Admin\AdminController@index');   
    Route::get('/admin/settings', 'Admin\SettingsController@edit');   
    Route::patch('/admin/settings', 'Admin\SettingsController@update');  

    Route::get('/admin/users', 'Admin\UserController@index');
    Route::get('/admin/users/create', 'Admin\UserController@create');
    Route::post('/admin/users', 'Admin\UserController@store');
    Route::get('/admin/users/{userId}', 'Admin\UserController@edit');
    Route::patch('/admin/users/{userId}', ['as' => 'users.update', 'uses' =>'Admin\UserController@update']);

    Route::get('/admin/templates', 'Admin\TemplateController@index');
    Route::get('/admin/templates/create', 'Admin\TemplateController@create');
    Route::post('/admin/templates', 'Admin\TemplateController@store');
    Route::get('/admin/template/{templateId}', 'Admin\TemplateController@edit');

    Route::get('/admin/tags', 'Admin\TagController@index');
    Route::get('/admin/tags/create', 'Admin\TagController@create');
    Route::post('/admin/tags', 'Admin\TagController@store');
   // Route::delete('/admin/tags/{tagId}', 'Admin\TagController@delete');
    Route::get('/admin/tags/{tagId}', 'Admin\TagController@edit');
    Route::patch('/admin/tags/{tagId}', ['as' => 'tags.update', 'uses' =>'Admin\TagController@update']);

    Route::post('api/admin/templates/course', 'Admin\API\TemplateCourseController@store');
    Route::get('api/admin/templates/course/{templateId}', 'Admin\API\TemplateCourseController@edit');

    Route::get('/admin/competency-frameworks', 'Admin\CompetencyFrameworkController@index');
    Route::get('/admin/competency-frameworks/retrieve', 'Admin\CompetencyFrameworkController@retrieve');
    Route::get('/admin/competency-framework/create', 'Admin\CompetencyFrameworkController@create');
    Route::post('/admin/competency-framework', 'Admin\CompetencyFrameworkController@store');
    Route::post('/admin/competency-framework-category', 'Admin\CompetencyFrameworkCategoryController@store');
    Route::delete('/admin/competency-framework-category', 'Admin\CompetencyFrameworkCategoryController@destroy');
    Route::get('/admin/competency-framework/{cfId}', 'Admin\CompetencyFrameworkController@edit');

    Route::get('/admin/competency-frameworks/retrieve', 'Admin\CompetencyFrameworkController@retrieve');
    Route::get('/admin/competency-frameworks-categories/retrieve', 'Admin\CompetencyFrameworkCategoryController@retrieve');

    Route::get('/api/admin/settings', 'Admin\API\SettingsController@index');
    Route::post('/api/admin/template-rubric', 'Admin\API\TemplateRubricController@store');
    Route::delete('/api/admin/template-rubric', 'Admin\API\TemplateRubricController@destroy');
    Route::post('/api/admin/templates/section', 'Admin\API\TemplateSectionController@store');
    Route::post('/api/admin/admin/templates/section-field', 'Admin\API\TemplateSectionFieldController@store');
});