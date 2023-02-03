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
    return view('welcome');
});

Auth::routes();

Route::get('/', 'HomeController@index')->name('home');
Route::get('/home', 'HomeController@index')->name('home');
Route::post('/logout', 'HomeController@logout')->name('logout');

Route::get('/201File/{employee}', 'ProfileController@index');
Route::post('/201File/{employee}/update_password', 'ProfileController@update_password');

Route::get('Calendar', 'CalendarController@index');

Route::get('/Notifications', function () {
    $notifBell = auth()->user()->unreadNotifications()->orderBy('updated_at')->get();
    return response($notifBell);
});

Route::patch('/Notifications/{notification}', function ($notification) {
    auth()->user()->unreadNotifications()->find($notification)->markAsRead();
});