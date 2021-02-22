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


/*
|--------------------------------------------------------------------------
| Standard URL navigation
|--------------------------------------------------------------------------
*/

//Index Page
Route::get('/', function () {
    return view('welcome');
});

//loggedIn home page
Route::get('/home', function()
{
   return view('home'); 
});

//login page
Route::get('login', function()
{
   return view('auth/login'); 
});

//register page
Route::get('register', function()
{
    return view('auth\register');
});

//admin page
Route::get('admin', function(){
    return view('admin\adminactions');
});

//addJob page
Route::get('newjob', function () {
    return view('admin\newjob');
});

//contact page
Route::get('contact', function () {
    return view('contact');
});

/*
|--------------------------------------------------------------------------
| User Controller Routes
|--------------------------------------------------------------------------
 */

Route::get('/roles', 'UserController@manageRoles');

//Suspends a user
Route::post('suspend', 'UserController@suspend');

//Deletes a user
Route::post('delete', 'UserController@delete');

//Restores a user
Route::post('restore', 'UserController@restore');

//Logs out the active user
Route::get('logout', 'UserController@logout');

//manages login requests
Route::post('doLogin', 'UserController@login');

//account details page
Route::get('account', 'UserController@viewAccount');

//edit user details
Route::post('editUser', 'UserController@editUser');

//manages registration requests
Route::post('register', 'UserController@register');

Route::get('portfoliorequest', 'UserController@viewRequests');

Route::post('approverequest', 'UserController@approveRequest');

Route::post('denyrequest', 'UserController@denyRequest');

//Displays an account update request for a single user
Route::post('displayuser', 'UserController@displayUserRequest');

/*
|--------------------------------------------------------------------------
| Job Controller Routes
|--------------------------------------------------------------------------
 */

//Route for handling the addjob form
Route::post('addjob', 'JobController@add');

Route::get('showalljobs', 'JobController@showAll');

Route::post('deletejob', 'JobController@delete');

Route::post('editjob', 'JobController@edit');

Route::post('doeditjob', 'JobController@doEdit');
