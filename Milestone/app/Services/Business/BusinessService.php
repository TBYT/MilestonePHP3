<?php
namespace App\Services\Business;

use App\Services\Data\DaoService;
use App\Models\UserModel;

class BusinessService
{
    private $dao;
    
    public function __construct()
    {
    }
    
    public function addUser(UserModel $user, bool $isAdmin)
    {
        $this->dao = new DaoService();
        return $this->dao->addUser($user, $isAdmin);
    }
    
    public function updateUser(int $id, UserModel $user)
    { 
        $this->dao = new DaoService();
        return $this->dao->updateUser($id, $user);
    }
    
    public function suspendUser(int $id)
    {
        $this->dao = new DaoService();
        $this->dao->suspendUser($id);
    }
    
    public function deleteUser(int $id)
    {
        $this->dao = new DaoService();
        $this->dao->deleteUser($id);
    }
    
    public function isAdmin(int $id)
    {
        $this->dao = new DaoService();
        return $this->dao->isAdmin($id);
    }
    
    public function getUserID(UserModel $user)
    {
        $this->dao = new DaoService();
        return $this->dao->getUserID($user);
    }
    
    public function restoreUser(int $id)
    {
        $this->dao = new DaoService();
        $this->dao->restoreUser($id);
    }
    
    public function getUserDetails($id)
    {
        $this->dao = new DaoService();
        return $this->dao->getUserDetails($id);
    }
    
    public function getAllUsers()
    {
        $this->dao = new DaoService();
        return $this->dao->getAllUsers();
    }
    
    public function isSuspended(int $id)
    {
        $this->dao = new DaoService();
        return $this->dao->isSuspended($id);
    }
}

