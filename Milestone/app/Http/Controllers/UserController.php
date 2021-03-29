<?php

/**
 * Author: Thomas Biegel
 * CST-256
 * 2.23.21
 */

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

use App\Models\UserModel;
use App\Services\Business\BusinessService;
use App\Services\Data\Utility\ILoggerService;
use Carbon\Exceptions\Exception;
//use App\Services\Business\PrivilegeCheck;

class UserController extends BaseController
{
        use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    private $user;

    private $business;
    
    protected $logger;
    
    public function __construct(ILoggerService $logger)
    {
        $this->logger = $logger;
    }

    // Method to log user in
    public function login()
    {
        Log::info("Entering Login Controller Index()");
        $this->business = new BusinessService();

        // Grab user details
        $this->user = new UserModel();

        $this->user->setEmail(request()->get('email'));
        $this->user->setPassword(request()->get('password'));

        try {
        
        $id = (int) $this->business->getUserID($this->user);

        // if 0, the user doesnt' exist
        if ($id != 0) {
            // If the user is active
            if (! $this->business->isSuspended($id)) {
                // Get details and store session user
                $this->user = $this->business->getUserDetails($id);
                session()->put('user', $this->user);
                // die(print_r(session()->get('user')));
                $isAdmin = $this->business->isAdmin($id);
                session()->put('isAdmin', $isAdmin);
                return view('home');
            } // User suspended
            else {
                return view('suspended');
            }
        } // If the user does not exist or other error
        else {
            // Take failure message
            $message = "Could Not Login, Try Again";
            $data = [
                'message' => $message
            ];
            return view('auth\login')->with($data);
        }
        }
        catch (Exception $e)
        {
            $this->logger->error("Something went wrong with logging in: "+$e);
        }
    }

    // Method to register user, very similar to login
    public function register(Request $request)
    {
        $this->business = new BusinessService();
        $this->user = new UserModel();

        // Grab user details
        $this->user->setName(request()->get('name'));
        $this->user->setEmail(request()->get('email'));
        $this->user->setPassword(request()->get('password'));

        $admin = request()->get('role');
        // Assume they are user, TODO: this will need to be changed
        // into switch when more than 2 roles are added
        $isAdmin = false;
        if ($admin == 'admin') {
            $isAdmin = true;
        }

        try {
        // If they are added
        if ($this->business->addUser($this->user, $isAdmin)) {
            // Return success page
            session()->put('user', $this->user);
            session()->put('isAdmin', $isAdmin);

            //return redirect('sendemail');
            return view('home');
        } 
        else {
            // return failure page
            $message = "Could Not Register, You May Have Already Made An Account";
            $data = [
                'message' => $message
            ];
            return view('auth/register')->with($data);
        }
        }
        catch (Exception $e)
        {
            $this->logger->error("Something went wrong with registering user: "+$e);
        }
    }

    // Function to delete user based on id
    public function delete()
    {
        $this->business = new BusinessService();

        // grab user id
        $id = request()->get('id');

        try {
        $this->business->deleteUser($id);
        }
        catch (Exception $e)
        {
            $this->logger->error("Something went wrong with deleting user: "+$e);
        }
        // Return deletion page
        return $this->manageRoles();
    }

    // Suspends user based on id
    public function suspend()
    {
        $this->business = new BusinessService();

        // grab user id
        $id = request()->get('id');

        try {
        $this->business->suspendUser($id);
        }
        catch (Exception $e)
        {
            $this->logger->error("Something went wrong with suspending user: "+$e);
        }
        // Return suspended page
        return $this->manageRoles();
    }

    // Restores suspended user based on id
    public function restore()
    {
        $this->business = new BusinessService();

        $id = request()->get('id');

        try {
        $this->business->restoreUser($id);
        }
        catch (Exception $e)
        {
            $this->logger->error("Something went wrong with restoring user: "+$e);
        }

        return $this->manageRoles();
    }

    // Returns the account details page
    public function viewAccount()
    {
        //$this->pc = new PrivilegeCheck();
        
        $this->business = new BusinessService();

        // Gets the session user
        $this->user = session()->get('user');
        // die(print_r(session()->get('user')));

        $data = [
            'user' => $this->user,
        ];
        //return view('account')->with($data);
        
        return view('account')->with($data);
    }

    // TODO: return success or error message as well
    // Function to edit user details
    public function editUser()
    {
        $this->business = new BusinessService();
        $this->user = new UserModel();

        // Get user details
        $id = $this->business->getUserID(session()->get('user'));

        $this->user->setName(request()->get('name'));
        $this->user->setEmail(request()->get('email'));
        $this->user->setPassword(request()->get('password'));
        $this->user->setState(request()->get('state'));
        $this->user->setWebLink(request()->get('website'));
        $this->user->setCity(request()->get('city'));

        try {
        // Update user
        $this->business->updateUser($id, $this->user);
        }
        catch (Exception $e)
        {
            $this->logger->error("Something went wrong with updating user: "+$e);
        }
        session()->put('user', $this->user);
        
        $data = [
            'user' => $this->user
        ];

        // Redirect to account page w updated info
        return view('account')->with($data);
    }

    // function shows admin page
    public function manageRoles()
    {
        //$this->pc = new PrivilegeCheck();
        
        // Get all users that aren't admin
        $this->business = new BusinessService();
        try {
        $users = $this->business->getAllUsers();
        }
        catch (Exception $e)
        {
            $this->logger->error("Something went wrong with retrieving user roles: "+$e);
        }
        // die(print_r($users));

        // Return view
        $data = [
            'users' => $users,
            'user' => session()->get('user')
        ];

        return view('admin\manageroles')->with($data);
        //return view('admin\manageroles')->with($data);
    }

    // Function to logout
    public function logout()
    {
        // Unset the session user and isAdmin vars
        session()->remove('user');
        session()->remove('isAdmin');
        unset($this->user);

        // Return index
        return view('welcome');
    }
    
    
    //FUNCTIONS BELOW NOT IMPLEMENTED YET so no logging.
    public function displayUserRequest()
    {
        $id = request()->get('id');
        $name = request()->get('name');
        $this->business = new BusinessService();
        
        $portfolio = $this->business->findPortfolioRequestByID($id);
        
        $data = [
            'portfolio' => $portfolio, 
            'name' => $name,
            'id'=> $id
        ];
        
        return view('admin\portfoliorequest')->with($data);
    }
    
    public function viewRequests()
    {
        $this->business = new BusinessService();
        
        $users = $this->business->getReviewRequests();
        $data = ['users' => $users];
        
        return view('admin\request')->with($data);
    }
    
    public function approveRequest()
    {
        $this->business = new BusinessService();
        
        $id = request()->get('id');
        
        $this->business->approveRequest($id);
    }
    
    public function denyRequest()
    {
        $this->business = new BusinessService();
        
        $id = request()->get('id');
        
        $this->business->denyRequest($id);
    }
}

