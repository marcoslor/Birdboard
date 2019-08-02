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


Route::get('/', function () {
    return redirect('/projects');
});

Route::group(['middleware'=>'auth'], function (){

    Route::get('/projects','ProjectsController@index');
    Route::get('/projects/create','ProjectsController@create');
    Route::get('/projects/{project}','ProjectsController@show');
    Route::get('/projects/{project}/edit','ProjectsController@edit');

    Route::post ('/projects/{project}/tasks','ProjectTasksController@store');
    Route::post('/projects','ProjectsController@store');

    Route::patch('/tasks/{task}','ProjectTasksController@update');
    Route::patch('/projects/{project}','ProjectsController@update');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
