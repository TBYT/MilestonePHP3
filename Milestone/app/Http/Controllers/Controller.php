<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;

use App\Services\Business\BusinessService;
use App\Models\UserModel;
use Illuminate\Support\Facades\Bus;
use Psy\Command\BufferCommand;
use Illuminate\Bus\BusServiceProvider;

class Controller extends BaseController
{   
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    
    private $user;
    private $business;
    
    //Method to log user in
    public function login()
    {
        $this->business = new BusinessService();
        
        //Grab user details
        $this->user = new UserModel();
        
        $this->user->setEmail(request()->get('email'));
        $this->user->setPassword(request()->get('password'));
        
        $id = (int)$this->business->getUserID($this->user);
        
        //if 0, the user doesnt' exist
        if ($id != 0)
        {
            //If the user is active
            if (!$this->business->isSuspended($id))
            {
                //Get details and store session user
                $this->user = $this->business->getUserDetails($id); 
                session()->put('user', $this->user);
                //die(print_r(session()->get('user')));
                $isAdmin = $this->business->isAdmin($id);
                session()->put('isAdmin', $isAdmin);
                
                //Return loggedIn veiw with userdata
                $data = ['isAdmin' => $isAdmin, 'user' => $this->user];
                return view('home')->with($data);
            }
            
            //User suspended
            else 
            {
                return view('suspended');
            }
        }
        
        //If the user does not exist or other error
        else 
        {
            //Take failure message
            $message = "Could Not Login, Try Again";
            $data = ['message' => $message];
            return view('auth\login')->with($data);
        }
    }
    
    //Method to register user, very similar to login
    public function register(Request $request)
    {
        $this->business = new BusinessService();
        $this->user = new UserModel();
        
        //Grab user details
        $this->user->setName(request()->get('name'));
        $this->user->setEmail(request()->get('email'));
        $this->user->setPassword(request()->get('password'));
        
        $admin = request()->get('role');
        //Assume they are user, TODO: this will need to be changed 
        //into switch when more than 2 roles are added
        $isAdmin = false;
        if ($admin == 'admin')
        {
            $isAdmin = true;
        }
        
        //If they are added
        if ($this->business->addUser($this->user, $isAdmin))
        {
            //Return success page
            $id = $this->business->getUserID($this->user);
            $this->user = $this->business->getUserDetails($id);
            session()->put('user', $this->user);
            session()->put('isAdmin', $isAdmin);
            
            $data = ['user' => $this->user, 'isAdmin' => $isAdmin];
            
            return view('home')->with($data);
        }
        else 
        {
           //return failure page
            $message = "Could Not Register, You May Have Already Made An Account";
            $data = ['message' => $message];
            return view('auth/register')->with($data);
        }
    }           
    
    public function delete()
    {
        $this->business = new BusinessService();
        
        //grab user id
        $id = request()->get('id');
        
        $this->business->deleteUser($id);
        //Return deletion page
        return $this->admin();
    }
    
    public function suspend() 
    {
        $this->business = new BusinessService();
        
        //grab user id
        $id = request()->get('id');
        
        $this->business->suspendUser($id);
        //Return suspended page
        return $this->admin();
    }
    
    public function restore()
    {
        $this->business = new BusinessService();
        
        $id = request()->get('id');
        
        $this->business->restoreUser($id);
        
        return $this->admin();
    }
    
    public function viewAccount()
    {
        $this->business = new BusinessService();
        
        $this->user = session()->get('user');
        //die(print_r(session()->get('user')));
        $data = ['user' => $this->user, 'isAdmin' => session()->get('isAdmin')];
        return view('account')->with($data);
    }
    
    //TODO: return success or error message as well
    public function editUser()
    {
        $this->business = new BusinessService();
        $this->user = new UserModel();
        $id = $this->business->getUserID(session()->get('user'));
        
        $this->user->setName(request()->get('name'));
        $this->user->setEmail(request()->get('email'));
        $this->user->setPassword(request()->get('password'));
        $this->user->setState(request()->get('state'));
        $this->user->setWebLink(request()->get('website'));
        $this->user->setCity(request()->get('city'));
        
        $this->business->updateUser($id, $this->user);
        
        $data = ['user' => $this->user, 'isAdmin' => session()->get('isAdmin')];
        
        return view('account')->with($data);
    }
    
    public function admin()
    {
        $this->business = new BusinessService();
        $users = $this->business->getAllUsers();
        
        //die(print_r($users));
        
        $data = ['users' => $users, 'user' => session()->get('user')];
        
        return view('admin')->with($data);
    }
    
    public function logout()
    {
        session()->remove('user');
        unset($this->user);
        return view('welcome');
    }
}
