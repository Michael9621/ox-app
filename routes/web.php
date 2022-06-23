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
Route::get('/signup', 'UserController@signup')->name('signup');
Route::post('/register', 'UserController@receiverRegister')->name('register');

Route::get('/sender-signup', 'UserController@signupSender')->name('signupSender');
Route::post('/registerSender', 'UserController@senderRegister')->name('registerSender');


Route::get('/login', 'UserController@login')->name('login');
Route::post('/auth', 'UserController@auth')->name('auth');
Route::post('/logout','UserController@logout')->name('logout');


Route::middleware('auth')->group(function () {
    
    Route::get('/','UserController@home')->name('home');
    Route::get('/autocomplete','UserController@autocomplete')->name('autocomplete');
    Route::post('/photos', 'PhotoController@create')->name('photos');
    Route::post('/update/{photo}', 'PhotoController@update')->name('update_photo');
    Route::get('/download/{photo:slug}', 'PhotoController@download')->name('download-photo');
});

