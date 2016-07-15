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
    /** Routes to admin page, or start page if not logged in**/
    Route::get('/',  'HomeController@index');
    /** Start page **/
    Route::get('/start',  'Admin\StartController@index');
    /** Typography page **/
    Route::get('/typography', 'TypographyController@index');
    /** ???? **/
    Route::get('/lti/response', 'LTI\responseController@index');
    /** Dashboard **/
    Route::get('/dashboard', 'UserDashboardController@index');
    /** API READ Content Tags **/
    Route::get('/api/content-tags', 'API\ContentTagsController@index');
    /** API CREATE Content Tags **/
    Route::post('/api/content-tags', 'API\ContentTagsController@store');
    /** API DELETE Content Tags **/
    Route::delete('/api/content-tags', 'API\ContentTagsController@destroy');
    /** ???? **/
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
});

/** Dashboard Pages  **/
Route::group(['middleware' => ['web','auth']], function () {
    Route::get('/build-list', 'Dashboard\BuildListController@index');
});

/* Admin Routes */

Route::group(['middleware' => ['web','auth', 'checkAdmin']], function () {

    /** Admin Dashboard **/
    Route::get('/admin', 'Admin\AdminController@index');
    /** Admin Settings **/
    Route::get('/admin/settings', 'Admin\SettingsController@edit');   
    /** Admin Settings submit **/
    Route::patch('/admin/settings', 'Admin\SettingsController@update');  

    /** Manage Users **/
    Route::get('/admin/users', 'Admin\UserController@index');
    /** Register New User **/
    Route::get('/admin/users/create', 'Admin\UserController@create');
    /** ???? **/
    Route::post('/admin/users', 'Admin\UserController@store');
    /** Edit Roles for user **/
    Route::get('/admin/users/{userId}', 'Admin\UserController@edit');
    /** ???? **/
    Route::patch('/admin/users/{userId}', ['as' => 'users.update', 'uses' =>'Admin\UserController@update']);

    /** Manage Templates**/
    Route::get('/admin/templates', 'Admin\TemplateController@index');
    /** Create New Template Page**/
    Route::get('/admin/templates/create', 'Admin\TemplateController@create');
    /** ???CREATE New Template **/
    Route::post('/admin/templates', 'Admin\TemplateController@store');
    /** Edit Template **/
    Route::get('/admin/template/{templateId}', 'Admin\TemplateController@edit');

    /** Manage Tags **/
    Route::get('/admin/tags', 'Admin\TagController@index');
    /** Create New Tag Page **/
    Route::get('/admin/tags/create', 'Admin\TagController@create');
    /** ????CREATE New Tag **/
    Route::post('/admin/tags', 'Admin\TagController@store');
   // Route::delete('/admin/tags/{tagId}', 'Admin\TagController@delete');
    /** Edit Tag **/
    Route::get('/admin/tags/{tagId}', 'Admin\TagController@edit');
    /** ???? **/
    Route::patch('/admin/tags/{tagId}', ['as' => 'tags.update', 'uses' =>'Admin\TagController@update']);

    /** ??API CREATE Course **/
    Route::post('api/admin/templates/course', 'Admin\API\TemplateCourseController@store');
    /** ??API READ Course **/
    Route::get('api/admin/templates/course/{templateId}', 'Admin\API\TemplateCourseController@edit');

    /** Manage Competency Frameworks **/
    Route::get('/admin/competency-frameworks', 'Admin\CompetencyFrameworkController@index');
    // Route::get('/admin/competency-frameworks/retrieve', 'Admin\CompetencyFrameworkController@retrieve'); DUPLICATE
    /** Create Competency Framework Page **/
    Route::get('/admin/competency-framework/create', 'Admin\CompetencyFrameworkController@create');
    /** ??CREATE Competency Framework **/
    Route::post('/admin/competency-framework', 'Admin\CompetencyFrameworkController@store');
    /** ??CREATE Competency Framework Category **/
    Route::post('/admin/competency-framework-category', 'Admin\CompetencyFrameworkCategoryController@store');
    /** Edit Competency Framework **/
    Route::get('/admin/competency-framework/{cfId}', 'Admin\CompetencyFrameworkController@edit');

    /** API READ Competency Frameworks  **/
    Route::get('/admin/competency-frameworks/retrieve', 'Admin\CompetencyFrameworkController@retrieve');
    /** API READ Competency Frameworks Categories **/
    Route::get('/admin/competency-frameworks-categories/retrieve', 'Admin\CompetencyFrameworkCategoryController@retrieve');

    /** API READ Settings Table **/
    Route::get('/api/admin/settings', 'Admin\API\SettingsController@index');
    /** API CREATE Template Rubric **/
    Route::post('/api/admin/template-rubric', 'Admin\API\TemplateRubricController@store');
    /** API DELETE Template Rubric **/
    Route::delete('/api/admin/template-rubric', 'Admin\API\TemplateRubricController@destroy');
    /** API CREATE ??? **/
    Route::post('/api/admin/templates/section', 'Admin\API\TemplateSectionController@store');
    /** API CREATE ??? **/
    Route::post('/api/admin/admin/templates/section-field', 'Admin\API\TemplateSectionFieldController@store');
});