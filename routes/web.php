<?php

use Illuminate\Support\Facades\Route;

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
    return view('welcome');
});

Auth::routes([
    'register' => false, // Registration Routes...
    'reset' => false, // Password Reset Routes...
    'verify' => false, // Email Verification Routes...
]);

Route::group(['namespace' => 'App\Http\Controllers\Admin', 'prefix'=>'dashboard', 'middleware'=>'auth', 'as'=>'dashboard.'], function (){
    Route::get('/', 'HomeController@index')->name('home');
    Route::resource('roles', 'RoleController');
    Route::get('get-roles', 'RoleController@getRoles');
    Route::resource('admins', 'AdminController');
    Route::get('get-admins', 'AdminController@getAdmins');
    Route::resource('users', 'UserController');
    Route::get('get-users', 'UserController@getUsers');
    Route::resource('pharmacies', 'PharmacyController');
    Route::get('get-pharmacies', 'PharmacyController@getPharmacies');
    Route::resource('timetables', 'TimeTableController');
    Route::get('get-timetables', 'TimeTableController@timeTable');
    Route::post('assign-pharmacies', 'TimeTableController@assignPharmaciesToDate');
});
