<?php
namespace App\Services\Business;

use App\Services\Data\DaoService;
use App\Models\UserModel;

//Business service class, transfers data from dao to controller
class BusinessService
{
    //dao object
    private $dao;
    
    public function __construct()
    {
    }
    
    /**
     * adds the user
     * @param UserModel $user the user to be added
     * @param bool $isAdmin the role of the user
     * @return boolean whether the user was added
     */
    public function addUser(UserModel $user, bool $isAdmin)
    {
        $this->dao = new DaoService();
        return $this->dao->addUser($user, $isAdmin);
    }
    
    /**
     * updates the given user
     * @param int $id the id of the user to be updated
     * @param UserModel $user the new user details
     * @return boolean whether the user was successfuly updated
     */
    public function updateUser(int $id, UserModel $user)
    { 
        $this->dao = new DaoService();
        return $this->dao->updateUser($id, $user);
    }
    
    /**
     * Suspends a user
     * @param int $id the id of the user to be suspended
     */
    public function suspendUser(int $id)
    {
        $this->dao = new DaoService();
        $this->dao->suspendUser($id);
    }
    
    /**
     * Deletes a user
     * @param int $id id of the user to be deleted
     */
    public function deleteUser(int $id)
    {
        $this->dao = new DaoService();
        $this->dao->deleteUser($id);
    }
    
    /**
     * Checks if a user is an admin
     * @param int $id the id of the user to examine
     * @return boolean whether the user is an admin
     */
    public function isAdmin(int $id)
    {
        $this->dao = new DaoService();
        return $this->dao->isAdmin($id);
    }
    
    /**
     * gets the id of the specified user, used for logging in
     * @param UserModel $user the user credentials to pass in
     * @return number| the id of the user found, 0 if failure
     */
    public function getUserID(UserModel $user)
    {
        $this->dao = new DaoService();
        return $this->dao->getUserID($user);
    }
    
    /**
     * Unsuspends a user
     * @param int $id the id of the user to be restored
     */
    public function restoreUser(int $id)
    {
        $this->dao = new DaoService();
        $this->dao->restoreUser($id);
    }
    
    /**
     * Grabs all profile info of a user
     * @param int $id the id of the user to get details for
     * @return \App\Models\UserModel the user object for the user
     */
    public function getUserDetails($id)
    {
        $this->dao = new DaoService();
        return $this->dao->getUserDetails($id);
    }
    
    /**
     * function to get a list of all standard users
     * @return array|\App\Models\UserModel[] all standard users
     */
    public function getAllUsers()
    {
        $this->dao = new DaoService();
        return $this->dao->getAllUsers();
    }
    
    /**
     * tells whether a user is suspended
     * @param int $id the id of the user to examine
     * @return boolean whether the user is suspended
     */
    public function isSuspended(int $id)
    {
        $this->dao = new DaoService();
        return $this->dao->isSuspended($id);
    }
}

