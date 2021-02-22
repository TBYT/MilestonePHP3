<?php

/**
 * Author: Thomas Biegel
 * CST-256
 * 2.8.21
 */

namespace App\Services\Business;

use App\Services\Data\UserDataService;
use App\Services\Data\JobDataService;
use App\Models\UserModel;
use App\Models\JobModel;
use App\Services\Data\Utility\DataAccess;
use App\Models\PortfolioModel;

//Business service class, transfers data from dao to controller
class BusinessService
{
    private $dbname = "dbcst256";
    
    /**
     * adds the user
     * @param UserModel $user the user to be added
     * @param bool $isAdmin the role of the user
     * @return boolean whether the user was added
     */
    public function addUser(UserModel $user, bool $isAdmin)
    {
        $dbAccess = new DataAccess($this->dbname);
        $conn = $dbAccess->getConnection();
        $userdao = new UserDataService($conn);
        
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
    
    public function addJob(JobModel $job)
    {
        $dbAccess = new DataAccess($this->dbname);
        $conn = $dbAccess->getConnection();
        $userdao = new UserDataService($conn);
        $success = $userdao->addJob($job);
        $dbAccess->closeConnection();
        return $success;
    }
    
    public function getAllJobs()
    {
        $dbAccess = new DataAccess($this->dbname);
        $conn = $dbAccess->getConnection();
        $jobsdao = new JobDataService($conn);
        $jobs = $jobsdao->getAllJobs();
        $dbAccess->closeConnection();
        return $jobs;
    }
    
    
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
    
    public function findPortfolioRequestByID($id)
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
    
    public function approveRequest($id)
    {
        $dbAccess = new DataAccess($this->dbname);
        $conn = $dbAccess->getConnection();
        $userdao = new UserDataService($conn);
        
        $success = $userdao->approveRequest($id);
        $dbAccess->closeConnection();
        
        return $success;
    }
    
    public function denyRequest($id)
    {
        $dbAccess = new DataAccess($this->dbname);
        $conn = $dbAccess->getConnection();
        $userdao = new UserDataService($conn);
        $userdao->denyRequest($id);
        
        $dbAccess->closeConnection();
    }
}

