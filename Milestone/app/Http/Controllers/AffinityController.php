<?php
/**
 * Author: Thomas Biegel
 * CST-256
 * 2.21.21
 */

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use App\Services\Business\BusinessService;
use Illuminate\Support\Facades\Bus;

class AffinityController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    
    private $group;
    private $businessService;
    
    
    //Below are some very basic function for the affinity controller,
    //Note that NONE OF THESE ARE FINISHED
    
    //Function to add an affinity group
    public function create()
    {
        $this->businessService = new BusinessService();
        
        $group = request()->get('name');
        $description = request()->get('description');
        
        $message = 'Group Created!';
          
        if (!$this->businessService->createAffinityGroup($group, $description))
        {
            $message = 'Sorry, this group could not be created';
        }
        
        $data = [
            'message' => $message,
        ];
        
        return view('')->with($data);
    }
    
    public function view()
    {
        $this->businessService = new BusinessService();
        
        $id = request()->get('id');
        $user = session()->get('user');
        $userID = $this->businessService->getUserID($user);
        
        $group = $this->businessService->getGroupDetails($id);
        $users = $this->businessService->getAllUsersInGroup($id);
        
        $inGroup = $this->businessService->userInGroup($userID, $id);
        
        $data = [
            'group' => $group,
            'users' => $users,
            'inGroup' => $inGroup,
        ];
        
        return view('')->with($data);
    }
    
    public function delete()
    {
        $this->businessService = new BusinessService();
        
        $id = request()->get('id');
        
        $message = "Group Deleted!";
        
        if (!$this->businessService->deleteGroup($id))
        {
            $message = "Sorry, this group could not be deleted";
        }
        
        $data = [
            'message' => $message,
        ];
        
        return view('')->with($data);
    }
    
    public function edit()
    {
        $this->businessService = new BusinessService();
        
        $id = request()->get('id');
        
        $newName = request()->get('name');
        $newDesc = request()->get('description');
        
        $message = "Group Updated!";
        
        if (!$this->businessService->updateGroup($id, $newName, $newDesc))
        {
            $message = "Sorry, this group could not be updated";
        }
        
        $data = [
            'message' => $message,
        ];
        
        return view('')->with($data);
    }
    
    public function join()
    {
        $this->businessService = new BusinessService();
        
        $groupID = requset()->get('id');
        $userID = $this->businessService->getUserID(session()->get('user'));
        
        $message = "Group Joined";
        
        if (!$this->businessService->joinGroup($userID, $groupID))
        {
            $message = "Sorry, you could not join this group";
        }

        $data = [
            'message', $message,
        ];
        
        return view('')->with($data);
    }
    
    public function leave()
    {
        $this->businessService = new BusinessService();
        
        $groupID = requset()->get('id');
        $userID = $this->businessService->getUserID(session()->get('user'));
        
        $message = "You have left the group";
        
        if (!$this->businessService->leaveGroup($userID, $groupID))
        {
            $message = "Sorry, you could not leave this group";
        }
        
        $data = [
            'message', $message,
        ];
        
        return view('')->with($data);
    }
}
