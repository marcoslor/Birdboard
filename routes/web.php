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

Route::get('/', static function () {
    return redirect('/projects');
});


Route::group(['middleware' => 'auth'], static function () {
    Route::resource('projects', 'ProjectsController');
    Route::post('/projects/{project}/invitations', 'ProjectsInvitationsController@store');

    Route::post ('/projects/{project}/tasks','ProjectTasksController@store');
    Route::patch('/projects/{project}/tasks/{task}', 'ProjectTasksController@update');
});

Auth::routes();
