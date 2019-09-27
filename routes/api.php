<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('/', static function () {
    return view('SPA.app');
});

Route::get('/login', static function () {
    return view('SPA.app');
});

Route::group(['middleware' => ['auth:api']], static function () {
    Route::get('/user', static function (Request $request) {
        return $request->user();
    });

    Route::get('/projects/{project}', 'API\ProjectsController@show');
    Route::post('/projects', 'API\ProjectsController@store');
});
