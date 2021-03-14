<?php
/**
 * Author: Thomas Biegel
 * CST-256
 * 3.1.21
 */

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use App\Services\Business\BusinessService;
use Illuminate\Support\Facades\Bus;
//use App\Services\Business\PrivilegeCheck;

class AffinityController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    
    private $group;
    private $businessService;
    
    //TODO: most of these functions should just be calling the show all function, 
    //since they return the same view with virtuall the same data
    
    
    //Function to add an affinity group
    public function create()
    {
        //Initialize business layer
        $this->businessService = new BusinessService();
        
        //Get group details from request
        $group = request()->get('name');
        $description = request()->get('description');
        
        //Default to success
        $message = 'Group Created!';
          
        //Create the affinity group and display error msg if neccessary
        if (!$this->businessService->createAffinityGroup($group, $description))
        {
            $message = 'Sorry, this group could not be created';
        }
        
        //Get all affinity groups and return to the all groups page
        $groups = $this->businessService->getAllAffinityGroups();
        
        $data = [
            'message' => $message,
            'groups' => $groups,
        ];
        
        return view('allaffinitygroups')->with($data);
    }
    
    //Function to view one group
    public function view()
    {
        //$this->pc = new PrivilegeCheck();
        //Initialize business layer
        $this->businessService = new BusinessService();
        
        //Get the id from the request and the user id for the current session
        $id = request()->get('id');
        $user = session()->get('user');
        $userID = $this->businessService->getUserID($user);
        
        //Get the group and all of its users
        $group = $this->businessService->getGroupDetails($id);
        $users = $this->businessService->getAllUsersInGroup($id);
        
        //Pass if the user is in the group
        $inGroup = $this->businessService->userInGroup($userID, $id);
        
        //return the group view
        $data = [
            'group' => $group,
            'users' => $users,
            'groupID' => $id,
            'inGroup' => $inGroup,
        ];
        
        return view('viewaffinitygroup')->with($data);
    }
    
    //Function to delete an affinity group
    public function delete()
    {
        //Initialize business layer
        $this->businessService = new BusinessService();
        
        //Get the id from the request
        $id = request()->get('id');
        
        //Default is group deleted
        $message = "Group Deleted!";
        
        //Delete the group
        if (!$this->businessService->deleteGroup($id))
        {
            $message = "Sorry, this group could not be deleted";
        }
        
        //Get all new groups
        $groups = $this->businessService->getAllAffinityGroups();
        
        //Return the all groups view
        $data = [
            'groups' => $groups,
            'message' => $message,
        ];
        return view('allaffinitygroups')->with($data);
    }
    
    //Function to edit the details of one group
    public function edit()
    {
        //Initialize business layer
        $this->businessService = new BusinessService();
        
        //Get the id and new details from the request
        $id = request()->get('id');
        
        $newName = request()->get('name');
        $newDesc = request()->get('description');
        
        //Default is the group is updated
        $message = "Group Updated!";
        
        //Update details
        if (!$this->businessService->updateGroup($id, $newName, $newDesc))
        {
            $message = "Sorry, this group could not be updated";
        }
        
        //Return all groups view
        $groups = $this->businessService->getAllAffinityGroups();
        
        $data = [
            'message' => $message,
            'groups' => $groups,
        ];
        
        return view('allaffinitygroups')->with($data);
    }
    
    //Function for the current user to join a group
    public function join()
    {
        //Initialize business layer
        $this->businessService = new BusinessService();
        
        //Get the id from the request and the current session's user id
        $groupID = request()->get('id');
        $userID = $this->businessService->getUserID(session()->get('user'));
        
        //Default is success
        $message = "Group Joined";
        
        //Join the group
        if (!$this->businessService->joinGroup($userID, $groupID))
        {
            $message = "Sorry, you could not join this group";
        }
        
        //Return all groups view
        $groups = $this->businessService->getAllAffinityGroups();
        
        $data = [
            'message' => $message,
            'groups' => $groups,
        ];
        
        return view('allaffinitygroups')->with($data);
    }
    
    //Function for a user to leave a group
    public function leave()
    {
        //Initialize business layer
        $this->businessService = new BusinessService();
        
        //Get the id from the request and the current session userid
        $groupID = request()->get('id');
        $userID = $this->businessService->getUserID(session()->get('user'));
        
        //Default success
        $message = "You have left the group";
        
        //Leave the group
        if (!$this->businessService->leaveGroup($userID, $groupID))
        {
            $message = "Sorry, you could not leave this group";
        }
        
        //Get all groups
        $groups = $this->businessService->getAllAffinityGroups();
        
        //return all groups page
        $data = [
            'message' => $message,
            'groups' => $groups,
        ];
        
        return view('allaffinitygroups')->with($data);
    }
    
    //Function to show all groups
    public function showAll()
    {
        //$this->pc = new PrivilegeCheck();
        //Initialize business layer
        $this->businessService = new BusinessService();
        
        //Get all groups and return the view
        $groups = $this->businessService->getAllAffinityGroups();
        
        $data = [
            'groups' => $groups,
        ];
        
        return view('allaffinitygroups')->with($data);
    }
    
    //Show the edit page for a group
    public function showEdit()
    {
        //$this->pc = new PrivilegeCheck();
        //Initialize business layer
        $this->businessService = new BusinessService();
        
        //Get the id from the request
        $id = request()->get('id');
        
        //Get group details
        $group = $this->businessService->getAffinityGroupById($id);
        
        //Pass data and return edit view
        $data = [
            'group' => $group,
            'id' => $id,
        ];
        
        return view('admin/editaffinitygroup')->with($data);
    }
}
