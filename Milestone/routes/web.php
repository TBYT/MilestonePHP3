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

Route::get('/home', 'HomeController@index')->name('home');

Route::get('login', function()
{
   return view('auth/login'); 
});

Route::post('doLogin', 'Controller@login');

Route::get('account', 'Controller@viewAccount');

Route::post('editUser', 'Controller@editUser');

Route::post('register', 'Controller@register');

Route::get('registerpage', function()
{
    return view('auth\register');
});

Route::get('admin', 'Controller@admin');

Route::post('suspend', 'Controller@suspend');

Route::post('delete', 'Controller@delete');

Route::post('restore', 'Controller@restore');