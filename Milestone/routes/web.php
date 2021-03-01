<?php

use App\Services\Business\PrivilegeCheck;

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

$this->pc = new PrivilegeCheck();

//Index Page
Route::get('/', function () {
    return view('welcome');
});

//loggedIn home page
Route::get('/home', function()
{
    return view($this->pc->SecurityisLoggedIn('home')); 
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
    return view($this->pc->SecurityisAdmin('admin\adminactions'));
});

//addJob page
Route::get('newjob', function () {
    return view($this->pc->SecurityisAdmin('admin\newjob'));
});

//contact page
Route::get('contact', function () {
    return view('contact');
});

Route::get('jobsearch', function()
{
    return view($this->pc->SecurityisLoggedIn('jobsearch'));
});

Route::get('portfoliosearch', function()
{
    return view($this->pc->SecurityisLoggedIn('searchportfolios')); 
});

Route::get('newaffinitygroup', function()
{
    return view('admin\newaffinitygroup');
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

Route::post('searchjobs', 'JobController@search');

Route::post('viewjob', 'JobController@view');

/*
 |--------------------------------------------------------------------------
 | Portfolio Controller Routes
 |--------------------------------------------------------------------------
 */

Route::post('searchportfolios', 'PortfolioController@search');

//edit portfolio page
Route::post('editportfolio', 'PortfolioController@editPortfolio');

//view portfolio details
Route::get('portfolio', 'PortfolioController@viewPortfolio');

Route::get('addeducation', 'PortfolioController@addEducation');
Route::get('addhistory', 'PortfolioController@addHistory');
Route::get('addskill', 'PortfolioController@addSkill');

/*
 |--------------------------------------------------------------------------
 | Affinity Controller Routes
 |--------------------------------------------------------------------------
 */

Route::get('allaffinitygroups', 'AffinityController@showAll');

Route::post('deleteaffinitygroup', 'AffinityController@delete');

Route::get('viewaffinitygroup', 'AffinityController@view');

Route::post('addaffinitygroup', 'AffinityController@create');

Route::post('editaffinitygroup', 'AffinityController@showEdit');

Route::post('doeditaffinitygroup', 'AffinityController@edit');

Route::post('joinaffinitygroup', 'AffinityController@join');

Route::post('leaveaffinitygroup', 'AffinityController@leave');