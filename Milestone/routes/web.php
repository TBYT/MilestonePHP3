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

//Index Page
Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

//loggedIn page
Route::get('/home', 'HomeController@index')->name('home');

//login page
Route::get('login', function()
{
   return view('auth/login'); 
});

//function for managing login  requests
Route::post('doLogin', 'Controller@login');

//account details page
Route::get('account', 'Controller@viewAccount');

//edit user details
Route::post('editUser', 'Controller@editUser');

//manages registration requests
Route::post('register', 'Controller@register');

//register page
Route::get('registerpage', function()
{
    return view('auth\register');
});

//shows the admin page
Route::get('admin', 'Controller@admin');

//Suspends a user
Route::post('suspend', 'Controller@suspend');

//Deletes a user
Route::post('delete', 'Controller@delete');

//Restores a user
Route::post('restore', 'Controller@restore');

//Logs out the active user
Route::get('logout', 'Controller@logout');