<?php

/**
 * Author: Thomas Biegel
 * CST-256
 * 2.23.21
 */

namespace App\Services\Business;

use App\Services\Data\UserDataService;
use App\Services\Data\JobDataService;
use App\Models\UserModel;
use App\Models\JobModel;
use App\Services\Data\Utility\DataAccess;
use App\Models\PortfolioModel;
use App\Services\Data\PortfolioDataService;
use App\Services\Data\AffinityGroupDataService;

//Business service class, transfers data from dao to controller
class BusinessService
{
    private $dbname = "dbcst256";
    
    /**
     * Function to call if an ACID transaction fails
     * @param DataAccess $da the data access instance being used for the method
     * @return boolean false to signify that the method call failed
     */
    private function transactionFailed(DataAccess $da)
    {
        //Rollback the transaction and close the connection
        $da->rollbackTransaction();
        $da->closeConnection();
        
        //Return false (to reduce # of lines in class)
        return false;
    }
    
/*******************************************************************
 * User Functions
 *******************************************************************/    
    
    /**
     * adds the user
     * @param UserModel $user the user to be added
     * @param bool $isAdmin the role of the user
     * @return boolean whether the user was added
     */
    public function addUser(UserModel $user, bool $isAdmin)
    {
        //For each method, create new Database connection and DAO instance
        $dbAccess = new DataAccess($this->dbname);
        $conn = $dbAccess->getConnection();
        $userdao = new UserDataService($conn);
        
        //Query database, close connection, and return value
        $success = $userdao->addUser($user, $isAdmin);
        $dbAccess->closeConnection();
        return $success;
    }
    
    /**
     * updates the given user
     * @param int $id the id of the user to be updated
     * @param UserModel $user the new user details
     * @return boolean whether the user was successfuly updated
     */
    public function updateUser(int $id, UserModel $user)
    { 
        $dbAccess = new DataAccess($this->dbname);
        $conn = $dbAccess->getConnection();
        $userdao = new UserDataService($conn);
        
        $success = $userdao->updateUser($id, $user);
        $dbAccess->closeConnection();
        return $success;
    }
    
    /**
     * Suspends a user
     * @param int $id the id of the user to be suspended
     */
    public function suspendUser(int $id)
    {
        $dbAccess = new DataAccess($this->dbname);
        $conn = $dbAccess->getConnection();
        $userdao = new UserDataService($conn);
        
        $userdao->suspendUser($id);
        $dbAccess->closeConnection();
    }
    
    /**
     * Deletes a user
     * @param int $id id of the user to be deleted
     */
    public function deleteUser(int $id)
    {
        $dbAccess = new DataAccess($this->dbname);
        $conn = $dbAccess->getConnection();
        $userdao = new UserDataService($conn);
        
        $userdao->deleteUser($id);
        $dbAccess->closeConnection();
    }
    
    /**
     * Checks if a user is an admin
     * @param int $id the id of the user to examine
     * @return boolean whether the user is an admin
     */
    public function isAdmin(int $id)
    {
        $dbAccess = new DataAccess($this->dbname);
        $conn = $dbAccess->getConnection();
        $userdao = new UserDataService($conn);
        
        $isAdmin = $userdao->isAdmin($id);
        $dbAccess->closeConnection();
        return $isAdmin;
    }
    
    /**
     * gets the id of the specified user, used for logging in
     * @param UserModel $user the user credentials to pass in
     * @return number| the id of the user found, 0 if failure
     */
    public function getUserID(UserModel $user)
    {
        $dbConn = new DataAccess($this->dbname);
        $userdao = new UserDataService($dbConn->getConnection());
        
        $id = $userdao->getUserID($user);
        $dbConn->closeConnection();
        return $id;
    }
    
    /**
     * Unsuspends a user
     * @param int $id the id of the user to be restored
     */
    public function restoreUser(int $id)
    {
        $dbAccess = new DataAccess($this->dbname);
        $conn = $dbAccess->getConnection();
        $userdao = new UserDataService($conn);
        
        $userdao->restoreUser($id);
        $dbAccess->closeConnection();
    }
    
    /**
     * Grabs all profile info of a user
     * @param int $id the id of the user to get details for
     * @return \App\Models\UserModel the user object for the user
     */
    public function getUserDetails($id)
    {
        $dbAccess = new DataAccess($this->dbname);
        $conn = $dbAccess->getConnection();
        $userdao = new UserDataService($conn);
        
        $user = $userdao->getUserDetails($id);
        $dbAccess->closeConnection();
        return $user;
    }
    
    /**
     * function to get a list of all standard users
     * @return array|\App\Models\UserModel[] all standard users
     */
    public function getAllUsers()
    {
        $dbAccess = new DataAccess($this->dbname);
        $conn = $dbAccess->getConnection();
        $userdao = new UserDataService($conn);
        
        $users = $userdao->getAllUsers();
        $dbAccess->closeConnection();
        return $users;
    }
    
    /**
     * tells whether a user is suspended
     * @param int $id the id of the user to examine
     * @return boolean whether the user is suspended
     */
    public function isSuspended(int $id)
    {
        $dbAccess = new DataAccess($this->dbname);
        $conn = $dbAccess->getConnection();
        $userdao = new UserDataService($conn);
        
        $isSuspended = $userdao->isSuspended($id);
        $dbAccess->closeConnection();
        return $isSuspended;
    }
    
    //Function to search through the users by name
    public function searchByName(string $pattern)
    {
        $dbConn = new DataAccess($this->dbname);
        
        $userDAO = new UserDataService($dbConn->getConnection());
        
        //Returns a list of users
        $users = $userDAO->searchUsers($pattern);
        
        $list = array();
        
        //Get User ID
        foreach($users as $user)
        {
            $id = $userDAO->getUserID($user);
            $list[$id] = $user;
        }
        
        $dbConn->closeConnection();
        
        //List is an associative array of userIds mapped to full names
        return $list;
    }

    /**
     * Function to verify a user
     * @param int $id the id of the user to verify
     * @return bool whether the user was verified
     */
    public function verifyUser(int $id)
    {
        $dbConn = new DataAccess($this->dbname);
        $userDAO = new UserDataService($dbConn->getConnection());
        $userDAO->verifyUser($id);
        $dbConn->closeConnection();
    }
    
    /*******************************************************************
     * Job Functions
     *******************************************************************/    
    
    /**
     * Adds job to the database
     * @param JobModel $job the job to be added
     * @return boolean whether the job was added
     */
    public function addJob(JobModel $job)
    {
        //Note that a different dao is created for jobs and users
        $dbAccess = new DataAccess($this->dbname);
        $conn = $dbAccess->getConnection();
        $jobsdao = new JobDataService($conn);
        
        $success = $jobsdao->addJob($job);
        $dbAccess->closeConnection();
        return $success;
    }
   
    /**
     * Gets a list of all jobs in the database
     * @return \App\Models\JobModel[]
     */
    public function getAllJobs()
    {
        $dbAccess = new DataAccess($this->dbname);
        $conn = $dbAccess->getConnection();
        $jobsdao = new JobDataService($conn);
        
        $jobs = $jobsdao->getAllJobs();
        $dbAccess->closeConnection();
        //die(print_r($jobs));
        return $jobs;
    }
    
    /**
     * removes job from the database
     * @param int $id the id number of the job to be removed
     */
    public function deleteJob(int $id)
    {
        $dbAccess = new DataAccess($this->dbname);
        $conn = $dbAccess->getConnection();
        $success = $jobsdao = new JobDataService($conn);
        
        $jobsdao->deleteJob($id);
        $dbAccess->closeConnection();
        
        return $success;
    }
    
    /**
     * Gets the details of one job
     * @param int $id the id number of the job
     * @return \App\Models\JobModel the job accessed from the db
     */
    public function getJob(int $id)
    {
        $dbAccess = new DataAccess($this->dbname);
        $conn = $dbAccess->getConnection();
        $jobsdao = new JobDataService($conn);
        
        $job = $jobsdao->findByID($id);
        $dbAccess->closeConnection();
        
        return $job;
    }
    
    /**
     * Alters the job with the specified id to 
     * hold the properties of the passed job
     * @param JobModel $job the new properties for the job
     * @param int $id the id number of the job to be updated
     * @return boolean whether the job was successfuly edited
     */
    public function editJob(JobModel $job, int $id)
    {
        $dbAccess = new DataAccess($this->dbname);
        $conn = $dbAccess->getConnection();
        $jobsdao = new JobDataService($conn);
        
        $success = $jobsdao->updateJob($job, $id);
        $dbAccess->closeConnection();
        
        return $success;
    }
    
    
    /**
     * Retrieves all jobs that match the search query
     * @param string $searchTerm the job property to order the results by
     * @param string $pattern the string to match the job results to
     * @return JobModel[] the list of jobs matching the search
     */
    public function searchJobs($properties)
    {
        $dbAccess = new DataAccess($this->dbname);
        $conn = $dbAccess->getConnection();
        $jobsdao = new JobDataService($conn);
        
        $jobs = array();
        
        foreach($properties as $name => $value)
        {
            if ($value!=null)
            {
                foreach($jobsdao->search($name, $value) as $id => $job)
                {
                    $jobs[$id] = $job;
                }
            }
        }
        
        return $jobs;
    }
    
    //THESE FUNCTIONS ARE STILL BEING TESTED, NOT IMPLEMENTED YET
    
    /**
     * Gets an associative array of user ids mapped to names
     * for all users with active portfolio updates waiting
     * for approval
     * @return string[] the array of ids and users
     */
    public function getReviewRequests()
    {
        //TODO: uncomment this whent the real functionality is implemented
        //         $dbAccess = new DataAccess($this->dbname);
        //         $conn = $dbAccess->getConnection();
        //         $userdao = new UserDataService($conn);
        
        //         $ids = $userdao->getAllRequests();
        
        //         $users = array();
        
        //         foreach ($ids as $id)
        //         {
        //             $name = $userdao->getUserDetails($id)['name'];
        //             $users[$id] = $name;
        //         }
        
        //         $dbAccess->closeConnection();
        //         return $users;
        
        $users = array();
        $users = [1 => 'Thomas', 2 => 'Brian', 3 => 'MisterGuy'];
        return $users;
    }
    
    
    /*******************************************************************
     * Portfolio Functions
     *******************************************************************/ 
    
    /**
     * Grabs a specific portfolio request
     * @param int $id the user id of the portfolio
     * @return \App\Models\PortfolioModel the users portfolio
     */
    public function findPortfolioRequestByID(int $id)
    {
        //         $dbAccess = new DataAccess($this->dbname);
        //         $conn = $dbAccess->getConnecction();
        //         $userdao = new UserDataService($conn);
        
        //         $request = $userdao->findRequestByID($id);
        
        //         $dbAccess->closeConnection();
        
        //         return $request;
        
        $portfolio = new PortfolioModel();
        $portfolio->addEducation('test');
        $portfolio->addEducation('test2');
        $portfolio->addHistory('myFirstJob');
        $portfolio->addHistory('mySecondJob');
        $portfolio->addSkill('programming');
        $portfolio->addSkill('chess');
        
        return $portfolio;
    }
    
    /**
     * Approves a portfolio update request
     * @param int $id the id of the User
     * @return boolean whether the request could be approved
     */
    public function approveRequest(int $id)
    {
        $dbAccess = new DataAccess($this->dbname);
        $conn = $dbAccess->getConnection();
        $userdao = new UserDataService($conn);
        
        $success = $userdao->approveRequest($id);
        $dbAccess->closeConnection();
        
        return $success;
    }
    
    /**
     * Deletes a portfolio update request
     * @param int $id the id of the user
     */
    public function denyRequest(int $id)
    {
        $dbAccess = new DataAccess($this->dbname);
        $conn = $dbAccess->getConnection();
        $userdao = new UserDataService($conn);
        $userdao->denyRequest($id);
        
        $dbAccess->closeConnection();
    }
        

    public function getPortfolioDetails($portid)
    {
        $dbAccess = new DataAccess($this->dbname);
        $conn = $dbAccess->getConnection();
        $portdao = new PortfolioDataService($conn);
        
        $details = $portdao->getPortfolioDetails($portid);
            
        $model = new PortfolioModel();
            
        //ForEach statements to add data to the model
        foreach ($details['education'] as $education)
        {
            $model->addEducation($education);
        }
        
        foreach ($details['history'] as $history)
        {
            $model->addHistory($history);
        }
        
        foreach ($details['skills'] as $skills)
        {
            $model->addSkill($skills);
        }
        
        $dbAccess->closeConnection();
        
        return $model;
    }
        
    /**
     * updates the given portfolio
     * @param int $id the porfolio id to be updated
     * @param PortfolioModel $porfolio the new portfolio
     * @return boolean whether the portfolio was successfuly updated
     */
    public function updatePortfolio(int $portfolioID, PortfolioModel $portfolio)
    {
        //Create data access and dao object
        $dbAccess = new DataAccess($this->dbname);
        $conn = $dbAccess->getConnection();
        $portdao = new PortfolioDataService($conn);
        
        //Set autocommit to false and begin a transaction
        $dbAccess->setAutocommit(false);
        $dbAccess->beginTransaction();
        
        //Get current portfolio details
        $currentPortfolio = $portdao->getPortfolioDetails($portfolioID);
        
        //Get the lists of current and new skills
        $currentSkillList = $currentPortfolio['skills'];
        $newSkillList = $portfolio->getSkills();
        
        //Start at the first skill
        $index = 0;
        
        //For each item in the new list(It will never have more than the current list)
        for ($index; $index < count($newSkillList); $index++)
        {
            //Take the current and new skill
            $currentSkill = $currentSkillList[$index];
            $newSkill = $newSkillList[$index];
            
            //Need to make sure the current and new skills don't match
            if ($currentSkill == $newSkill)
            {
                continue;
            }
            
            //Update the current skill to match the new skill
            //If it fails, rollback the transaction
            //NB: this is kind of inneficient, because there may be a current skill
            //that already exactly matches the new skill but has a different index.
            //However, since I don't track indexes throughout the update portfolio page,
            //I couldn't think of a better way of doing it without writing a ton of extra code
            if (!$portdao->updateSkill($currentSkill, $newSkill, $portfolioID))
            {
                return $this->transactionFailed($dbAccess);
            }
        }
        
        //If there are extra items in the current list, delete them
        for ($index; $index < count($currentSkillList); $index++)
        {
            //If the delete fails, cancel transaction and return false
            if (!$portdao->deleteSkill($currentSkillList[$index], $portfolioID))
            {
                return $this->transactionFailed($dbAccess);
            }
        }
        
        //Repeat process above for history and education
        //TODO: copied code, make new method?
        $currentHistoryList = $currentPortfolio['history'];
        $newHistoryList = $portfolio->getHistory();
        
        $index = 0;
        for ($index; $index < count($newHistoryList); $index++)
        {
            $currentHistory = $currentHistoryList[$index];
            $newHistory = $newHistoryList[$index];
            
            //Need to make sure the current and new histories don't match
            if ($currentHistory == $newHistory)
            {
                continue;
            }
            
            if (!$portdao->updateHistory($currentHistory, $newHistory, $portfolioID))
            {
                return $this->transactionFailed($dbAccess);
            }
        }
        for ($index; $index < count($currentHistoryList); $index++)
        {
            if (!$portdao->deleteHistory($currentHistoryList[$index], $portfolioID))
            {
                return $this->transactionFailed($dbAccess);
            }
        }
        
        $currentEducationList = $currentPortfolio['education'];
        $newEducationList = $portfolio->getEducation();
        
        $index = 0;
        for ($index; $index < count($newEducationList); $index++)
        {
            //Need to take the institution index of the education instead of the value directly,
            //Since each entry in the education table is a sub array
            $currentInstitution = $currentEducationList[$index]['institution'];
            $newEducation = $newEducationList[$index];
            
            //Need to make sure the current and new skills don't match
            if ($currentInstitution == $newEducation['institution'] &&
                $currentEducationList[$index]['startdate'] == $newEducation['startdate'] &&
                $currentEducationList[$index]['enddate'] == $newEducation['enddate'] &&
                $currentEducationList[$index]['gpa'] == $newEducation['gpa'])
            {
                continue;
            }
            
            if (!$portdao->updateEducation($currentInstitution, $newEducation, $portfolioID))
            {
                return $this->transactionFailed($dbAccess);
            }
        }
        for ($index; $index < count($currentEducationList); $index++)
        {
            //See above
            if (!$portdao->deleteEducation($currentEducationList[$index]['institution'], $portfolioID))
            {
                return $this->transactionFailed($dbAccess);
            }
        }
        
        //Finish the transaction and close the connection if everything succeeds
        //Then return true
        $dbAccess->commitTransaction();
        $dbAccess->closeConnection();
        return true;
    }
        
    /**
     * gets the id of the specified user, used for logging in
     * @param UserModel $user the user credentials to pass in
     * @return number| the id of the user found, 0 if failure
     */
    public function getPortfolioID($id)
    {
        $dbConn = new DataAccess($this->dbname);
        $userdao = new PortfolioDataService($dbConn->getConnection());
        $id = $userdao->getPortfolioID($id);
        $dbConn->closeConnection();
        return $id;
    }
    
    public function createPortfolio(int $userID)
    {
        $dbConn = new DataAccess($this->dbname);
        $portfolioDAO = new PortfolioDataService($dbConn->getConnection());
        $id = $portfolioDAO->addPortfolio($userID);
        $dbConn->closeConnection();
    }
    
    /**
     * Function adds a blank education to the portfolio
     * @param int $portfolioID the id of the portfolio to edit
     */
    public function addEducation(int $portfolioID)
    {
        $dbConn = new DataAccess($this->dbname);
        $portfolioDAO = new PortfolioDataService($dbConn->getConnection());
        
        //echo('Running the add education method');
        $portfolioDAO->addEducation($portfolioID);
    }
    
    /**
     * Function adds a blank history to the portfolio
     * @param int $portfolioID the id of the portfolio to edit
     */
    public function addHistory(int $portfolioID)
    {
        $dbConn = new DataAccess($this->dbname);
        $portfolioDAO = new PortfolioDataService($dbConn->getConnection());
        $portfolioDAO->addHistory($portfolioID);
    }
    
    /**
     * Function adds a blank skill to the portfolio
     * @param int $portfolioID the id of the portfolio to edit
     */
    public function addSkill(int $portfolioID)
    {
        $dbConn = new DataAccess($this->dbname);
        $portfolioDAO = new PortfolioDataService($dbConn->getConnection());
        $portfolioDAO->addSkill($portfolioID);
    }
    
    /*******************************************************************
     * Affinity Group Functions
     *******************************************************************/ 
    
    /**
     * create a new group
     * @param string $group the group name
     * @param string $description the description for the group
     * @return boolean whether the group was successfuly created
     */
    public function createAffinityGroup(string $group, string $description)
    {
        //Initialize data layer
        $dbConn = new DataAccess($this->dbname);
        $affinityDAO = new AffinityGroupDataService($dbConn->getConnection());
        
        //Default return is false
        $success = false;
        
        //Add the group
        if ($affinityDAO->addGroup($group, $description))
        {
            $success = true;
        }
        
        //Close connection and return status
        $dbConn->closeConnection();
        return $success;
    }
    
    /**
     * Get the details for a specified group
     * @param int $id the id of the group to get
     * @return string[] an array of groups, mapping id => name
     */
    public function getGroupDetails(int $id)
    {
        //Initialize data layer
        $dbConn = new DataAccess($this->dbname);
        $affinityDAO = new AffinityGroupDataService($dbConn->getConnection());
        
        //Get group details, close connection and return the group
        $group = $affinityDAO->getGroupDetails($id);
        $dbConn->closeConnection();
        return $group;
    }
    
    /**
     * Get all of the users in the specified group
     * @param int $id the group to search for the users in 
     * @return mixed[]|string[] a list of users, mapped id => name
     */
    public function getAllUsersInGroup(int $id)
    {
        //Initialize the data layer
        //Need to access users as well, so create userDAO
        $dbConn = new DataAccess($this->dbname);
        $affinityDAO = new AffinityGroupDataService($dbConn->getConnection());
        $userDAO = new UserDataService($dbConn->getConnection());
        
        //Get all the users in the group
        $ids = $affinityDAO->getAllUsers($id);
        
        //For each user, find their name and put it into a new array
        $users = array();
        foreach ($ids as $userID)
        {
            $user = $userDAO->getUserDetails($userID);
            $name = $user->getName();
            
            //Map id to name
            $users[$userID] = $name;
        }
        
        //Close connection and return array
        $dbConn->closeConnection();
        return $users;
    }
    
    /**
     * Determine if the specified user is in the group
     * @param int $userID the id of the user to check
     * @param int $id the id of the group
     * @return boolean whether the user is a member of the group
     */
    public function userInGroup(int $userID, int $id)
    {
        //Initialize business layer
        $dbConn = new DataAccess($this->dbname);
        $affinityDAO = new AffinityGroupDataService($dbConn->getConnection());
        
        //Check if the user is in the group
        $inGroup = $affinityDAO->userInGroup($userID, $id); 
        $dbConn->closeConnection();
        
        return $inGroup;
    }
    
    /**
     * Delete a group
     * @param int $id the group to delete
     * @return boolean whether the group was deleted
     */
    public function deleteGroup(int $id)
    {
        //Initialize the data layer
        $dbConn = new DataAccess($this->dbname);
        $affinityDAO = new AffinityGroupDataService($dbConn->getConnection());
        
        //Delete the group and return whether it was successful
        $success = $affinityDAO->deleteGroup($id);
        $dbConn->closeConnection();
        
        return $success;
    }
    
    /**
     * Function to update a group's details
     * @param int $id the id of the group to update
     * @param string $name the new name for the group
     * @param string $desc the new description for the group
     * @return boolean whether the group was successfully updated
     */
    public function updateGroup(int $id, string $name, string $desc)
    {
        //Initialize data layer
        $dbConn = new DataAccess($this->dbname);
        $affinityDAO = new AffinityGroupDataService($dbConn->getConnection());
        
        //Update the group
        $success = $affinityDAO->updateGroup($id, $name, $desc);
        
        //Close the connection and return if the update was successful
        $dbConn->closeConnection();
        return $success;
    }
    
    /**
     * Put the specified user into the group
     * @param int $userID the user to join
     * @param int $id the id of the group
     * @return boolean whether the user successfuly joined
     */
    public function joinGroup(int $userID, int $id)
    {
        //Initialize the data layer
        $dbConn = new DataAccess($this->dbname);
        $affinityDAO = new AffinityGroupDataService($dbConn->getConnection());
        
        //Try to join the group
        $success = $affinityDAO->joinGroup($userID, $id);
        
        //Close the connection and return if the query was successful
        $dbConn->closeConnection();
        return $success;
    }
    
    /**
     * Leave the group, works almost the same as the joinGroup
     * @param int $userID the id of the user to join
     * @param int $id the id of the group
     * @return boolean whether the user joined
     */
    public function leaveGroup(int $userID, int $id)
    {
        //Initialize the data layer
        $dbConn = new DataAccess($this->dbname);
        $affinityDAO = new AffinityGroupDataService($dbConn->getConnection());
        
        //Leave the group
        $success = $affinityDAO->leaveGroup($userID, $id);
        
        //Close the connection
        $dbConn->closeConnection();
        return $success;
    }
    
    public function getAllAffinityGroups()
    {
        $dbConn = new DataAccess($this->dbname);
        $affinityDAO = new AffinityGroupDataService($dbConn->getConnection());
        
        $groups = $affinityDAO->getAll();
        
        $dbConn->closeConnection();
        
        return $groups;
    }
    
    /**
     * Get the specified affinity group by its id
     * TODO: this function is the exact same as getDetails, remove it
     * @param int $id the id of the group
     * @return string[] the groups details
     */
    public function getAffinityGroupByID(int $id)
    {
        //Initialize the data layer
        $dbConn = new DataAccess($this->dbname);
        $affinityDAO = new AffinityGroupDataService($dbConn->getConnection());
        
        //Get the group details
        $group = $affinityDAO->getByID($id);
        
        //Close the connection and return the group
        $dbConn->closeConnection();
        return $group;
    }
    
    public function getAppliedJobs($id)
    {
        //Initialize business layer
        $dbConn = new DataAccess($this->dbname);
        $jobsDAO = new JobDataService($dbConn->getConnection());
        
        //get jobs user applied to
        $jobs = $jobsDAO->appliedJobs($id);
        $dbConn->closeConnection();
        return $jobs;
    }
    
    public function jobApply($userID, $jobid)
    {
        $dbConn = new DataAccess($this->dbname);
        $jobsDAO = new JobDataService($dbConn->getConnection());
        
        $success = $jobsDAO->apply($userID, $jobid);
        
        //Close the connection and return if the query was successful
        $dbConn->closeConnection();
        return $success;
    }
}
