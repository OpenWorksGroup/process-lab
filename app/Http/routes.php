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
    /** Home, routes elsewhere **/
    Route::get('/',  'HomeController@index');

    /** ???? **/
    Route::get('/home',  'HomeController@index');

    /** Start page **/
    Route::get('/start',  'Admin\StartController@index');

    Route::get('/lti/response', 'LTI\responseController@index');

    /** User Dashboard page **/
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
    /** Artifact Builder page **/
    Route::get('/artifact-builder/{templateId}',  'Artifact\BuilderController@index');

    /** CREATE/UPDATE Content **/
    Route::post('/artifact-builder',  'Artifact\BuilderController@store');

    /** ???? **/
    Route::get('/artifact-edit/{contentId}',  'Artifact\BuilderController@edit');

    /** ???? **/
    Route::post('/artifact-edit',  'Artifact\BuilderController@update');

    /** Section page **/
    Route::get('/artifact/{contentId}/{sectionId}', 'Artifact\SectionController@edit');

    /** CREATE/UPDATE Content Field Content **/
    Route::post('/artifact/field', 'Artifact\FieldController@store');

    /** DELETE Content Field Content **/
    Route::delete('/artifact/field/delete','Artifact\FieldController@destroy');

    /** Content Notes page **/
    Route::get('/artifact-notes/{contentId}', 'Artifact\NotesController@edit');

    /** CREATE/UPDATE Content Note **/
    Route::post('/artifact-notes', 'Artifact\NotesController@store');

    /** Tags page **/
    Route::get('/artifact-tags/{contentId}', 'Artifact\TagsController@edit');

    /** ???? **/
    Route::post('/artifact-feedback-switch', 'Artifact\ContentSectionCommentController@store');

    /** ???? **/
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
    Route::get('/artifact-delete/{contentId}', 'API\DeleteArtifactController@update');
});

/** Dashboard Pages  **/
Route::group(['middleware' => ['web','auth']], function () {
    Route::get('/build-list', 'Dashboard\BuildListController@index');
});

/** Admin Routes **/
Route::group(['middleware' => ['web','auth', 'checkAdmin']], function () {

    /** Admin Dashboard page **/
    Route::get('/admin', 'Admin\AdminController@index');

    /** Admin Site Settings page **/
    Route::get('/admin/settings', 'Admin\SettingsController@edit'); 

    /** UPDATE Site Settings **/
    Route::patch('/admin/settings', 'Admin\SettingsController@update');  

    /** Manage Users page **/
    Route::get('/admin/users', 'Admin\UserController@index');

    /** Register New User page **/
    Route::get('/admin/users/create', 'Admin\UserController@create');

    /** CREATE New User **/
    Route::post('/admin/users', 'Admin\UserController@store');

    /** Edit Roles for a given user page **/
    Route::get('/admin/users/{userId}', 'Admin\UserController@edit');

    /** UPDATE User Roles **/
    Route::patch('/admin/users/{userId}', ['as' => 'users.update', 'uses' =>'Admin\UserController@update']);

    /** Manage Templates page **/
    Route::get('/admin/templates', 'Admin\TemplateController@index');

    /** Create New Template page **/
    Route::get('/admin/templates/create', 'Admin\TemplateController@create');

    /** CREATE New Template **/
    Route::post('/admin/templates', 'Admin\TemplateController@store');

    /** Edit Template page **/
    Route::get('/admin/template/{templateId}', 'Admin\TemplateController@edit');

    /** Manage Tags page **/
    Route::get('/admin/tags', 'Admin\TagController@index');

    /** Create New Tag page **/
    Route::get('/admin/tags/create', 'Admin\TagController@create');

    /** CREATE New Tag **/
    Route::post('/admin/tags', 'Admin\TagController@store');
    // Route::delete('/admin/tags/{tagId}', 'Admin\TagController@delete');

    /** Edit Tag page **/
    Route::get('/admin/tags/{tagId}', 'Admin\TagController@edit');

    /** UPDATE Tag **/
    Route::patch('/admin/tags/{tagId}', ['as' => 'tags.update', 'uses' =>'Admin\TagController@update']);

    /** API CREATE Course **/
    Route::post('api/admin/templates/course', 'Admin\API\TemplateCourseController@store');

    /** API READ Course **/   //@edit does not exist in TemplateCourseController yet
    Route::get('api/admin/templates/course/{templateId}', 'Admin\API\TemplateCourseController@edit');

    /** Manage Competency Frameworks page **/
    Route::get('/admin/competency-frameworks', 'Admin\CompetencyFrameworkController@index');

    /** Create Competency Framework page **/
    Route::get('/admin/competency-framework/create', 'Admin\CompetencyFrameworkController@create');

    /** CREATE Competency Framework **/
    Route::post('/admin/competency-framework', 'Admin\CompetencyFrameworkController@store');
    
    /** CREATE Competency Framework Category **/
    Route::post('/admin/competency-framework-category', 'Admin\CompetencyFrameworkCategoryController@store');

    /** ???? **/
    Route::delete('/admin/competency-framework-category', 'Admin\CompetencyFrameworkCategoryController@destroy');

    /** Edit Competency Framework page **/
    Route::get('/admin/competency-framework/{cfId}', 'Admin\CompetencyFrameworkController@edit');

    /** READ Competency Frameworks **/
    Route::get('/admin/competency-frameworks/retrieve', 'Admin\CompetencyFrameworkController@retrieve');

    /** READ Competency Frameworks Categories **/
    Route::get('/admin/competency-frameworks-categories/retrieve', 'Admin\CompetencyFrameworkCategoryController@retrieve');

    /** API READ Settings Table **/
    Route::get('/api/admin/settings', 'Admin\API\SettingsController@index');
    
    /** API CREATE Template Rubric **/
    Route::post('/api/admin/template-rubric', 'Admin\API\TemplateRubricController@store');
    
    /** API DELETE Template Rubric **/
    Route::delete('/api/admin/template-rubric', 'Admin\API\TemplateRubricController@destroy');
    
    /** API CREATE Template Section **/
    Route::post('/api/admin/templates/section', 'Admin\API\TemplateSectionController@store');
    
    /** API CREATE Template Section Field **/
    Route::post('/api/admin/admin/templates/section-field', 'Admin\API\TemplateSectionFieldController@store');
});