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

Auth::routes();

Route::get('/', 'HomeController@index')->name('home');

Route::group(['middleware' => ['auth']], function() {
    
    //Change Profile Details
    Route::get('/profile','ProfileController@index')->name('profile');
    Route::patch('/profile-detail/{id}','ProfileController@update')->name('updateProfile');
    Route::patch('/user-thumb/{id}','ProfileController@updateThumb')->name('updateThumb');
    
    // Change Password
    Route::get('/change-password','ProfileController@changePassword')->name('changePwd');
    Route::patch('/update-password/{id}','ProfileController@updatePassword')->name('updatePwd');
});