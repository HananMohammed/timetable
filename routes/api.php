<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::post('/login', 'AuthenticationController@login');

Route::group(['middleware'=>['auth:sanctum'/*,'user.check'*/]],function () {
    Route::get('/user', 'UserController@getUser');
    Route::post('/logout', 'AuthenticationController@signout');
    Route::get('/user-timetable/{id}', 'UserTimetableController@timTable');
    Route::get('pharmacies', 'UserTimetableController@pharmacies');
});