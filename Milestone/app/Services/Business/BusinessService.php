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

//Business service class, transfers data from dao to controller
class BusinessService
{
    private $dbname = "test";
    
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
        $jobsdao = new JobDataService($conn);
        
        $jobsdao->deleteJob($id);
        $dbAccess->closeConnection();
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
    public function searchJobs(string $searchTerm, string $pattern)
    {
        $dbAccess = new DataAccess($this->dbname);
        $conn = $dbAccess->getConnection();
        $jobsdao = new JobDataService($conn);
        
        $jobs = $jobsdao->search($searchTerm, $pattern);
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
    
    /**
     * Function to add a portfolio 
     * @param PortfolioModel $portfolio The portfolio to be added
     * @param int $id the id of the currently logged in user
     * @return bool whether the model was successfuly added
     */
    public function addPortfolio(PortfolioModel $portfolio, int $id)
    {
        //Create DBAccess class and get connection
        //Instantiate the Data Layer
        
        //Set autocommit to false (Must be an ACID transaction)
        //Begin Transaction
        
        //Create empty portfolio model with the user id
        
        //Get portfolio id if needed
        
        //Call the add education function for each education
        //Call the add history function for each job history
        //Call the add skill function for each skill
        
        //If any of the database connections failed, rollback
        //Else commit transaction
        
        //Close database connection
        //Return success var
        return true;
    }
    
//     public function getPortfolioDetails($id)
//     {
//         $dbAccess = new DataAccess($this->dbname);
//         $conn = $dbAccess->getConnection();
//         $portdao = new PortfolioDataService($conn);
        
//         $details = $portdao->getPortfolioDetails($id);
        
//         $model = new PortfolioModel();
        
//         //
//         foreach ($details['education'] as $education)
//         {
//             $model->addEducation($education);
//         }
        
//         foreach ($details['history'] as $history)
//         {
//             $model->addHistory($history);
//         }
        
//         foreach ($details['skills'] as $skills)
//         {
//             $model->addSkill($skills);
//         }
        
//         $dbAccess->closeConnection();
        
//         return $model;
//     }
    
//     /**
//      * updates the given portfolio
//      * @param int $id the id of the user to be updated
//      * @param UserModel $user the new user details
//      * @return boolean whether the user was successfuly updated
//      */
//     public function updatePortfolio(int $id, PortfolioModel $user)
//     {
//         $dbAccess = new DataAccess($this->dbname);
//         $conn = $dbAccess->getConnection();
//         $userdao = new PortfolioDataService($conn);
        
//         $success = $userdao->updatePortfolio($id, $user);
//         $dbAccess->closeConnection();
        
//         return $success;
//     }
    
//     /**
//      * gets the id of the specified user, used for logging in
//      * @param UserModel $user the user credentials to pass in
//      * @return number| the id of the user found, 0 if failure
//      */
//     public function getPortfolioID($id)
//     {
//         $dbConn = new DataAccess($this->dbname);
//         $userdao = new PortfolioDataService($dbConn->getConnection());
//         $id = $userdao->getPortfolioID($id);
//         $dbConn->closeConnection();
//         return $id;
//     }
       
        
        /*
         * Gets the portfolio details and updates the portfolio model when returned from the database.
         */
        public function getPortfolioDetails($id, $portid)
        {
            $dbAccess = new DataAccess($this->dbname);
            $conn = $dbAccess->getConnection();
            $portdao = new PortfolioDataService($conn);
            
            $details = $portdao->getPortfolioDetails($id, $portid);
            
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
         * @param int $id the id of the user to be updated
         * @param UserModel $user the new user details
         * @return boolean whether the user was successfuly updated
         */
        public function updatePortfolio(int $id, PortfolioModel $user)
        {
            $dbAccess = new DataAccess($this->dbname);
            $conn = $dbAccess->getConnection();
            $portdao = new PortfolioDataService($conn);
            
            $success = $portdao->updatePortfolio($id, $user);
            $dbAccess->closeConnection();
            
            return $success;
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
    }

