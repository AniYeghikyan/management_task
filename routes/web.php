<?php

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

use App\Task;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\TaskController;

Auth::routes(['verify' => true]);


Route::group(['middleware' => ['web']], function () {
    /**
     * Show Task Dashboard
     */
    Route::get('/', 'TaskController@getTasksPage');

    /* Add New Task */
    Route::post('/task', 'TaskController@addTask');

    /* Edit Task */
    Route::post('/task/{id}/update', 'TaskController@editTask')->name('update-task');

    /* Delete Task */
    Route::delete('/task/{id}','TaskController@deleteTask');
    /* search by user */
    Route::put('user/{id}', 'UserController@searchByUser');
});

Route::group(['middleware' => 'web'], function () {
    Route::auth();

});
Route::get('/home', 'HomeController@index')->name('home')->middleware('verified');

Route::get('invite', 'InviteController@invite')->name('invite');
Route::post('invite', 'InviteController@process')->name('process');
// {token} is a required parameter that will be exposed to us in the controller method
Route::get('accept/{token}', 'InviteController@accept')->name('accept');
