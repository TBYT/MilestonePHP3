<?php

/**
 * Author: Thomas Biegel
 * CST-256
 * 2.8.21
 */

namespace App\Services\Data;

use App\Models\UserModel;
use Exception;
use mysqli;

//Data Access Class
class UserDataService
{
    private $conn;
    
    //Constructor that creates a connection with the database
    public function __construct($conn)
    {
        //Create a connection to the database
        $this->conn = $conn;
    }
    
    /**
     * Adds a user as either a standard user or an admin
     * @param UserModel $user the user to be added
     * @param bool $isAdmin whether the user is an admin
     * @return boolean whether the user is added
     */
    public function addUser(UserModel $user, bool $isAdmin)
    {   
        //Standard role is user
        $role = 1;
        
        if ($isAdmin)
        {
            $role = 2;
        }
        
        //Create User
        $sql = "INSERT INTO user
                    (name, email, password, tbl_roles_id_role)
                    VALUES ('{$user->getName()}', '{$user->getEmail()}', '{$user->getPassword()}', '$role')";
        
        //run statement          
        mysqli_query($this->conn, $sql);
        $success = (mysqli_affected_rows($this->conn) > 0);
        
        return $success;
    }
    
    /**
     * Function to update user info
     * @param int $id the id of the user to be updated
     * @param UserModel $user the new user info
     * @return boolean whether the user was updated
     */
    public function updateUser(int $id, UserModel $user)
    {
        //sql
        $sql = "UPDATE user
                    SET name = '{$user->getName()}', email = '{$user->getEmail()}', 
                        password = '{$user->getPassword()}', bio = '{$user->getBio()}', 
                        website = '{$user->getWebLink()}', city = '{$user->getCity()}', 
                        state = '{$user->getState()}', field = '{$user->getField()}', 
                        picture = '{$user->getPicture()}'
                    WHERE id = '$id'";
        
        //Query statement, return whether it affects any rows
        mysqli_query($this->conn, $sql);
        $success = mysqli_affected_rows($this->conn) > 0;
        return $success;
    }
    
    /**
     * function to suspend a user
     * @param int $id the user to be suspended
     */
    public function suspendUser(int $id)
    {
        $sql = "UPDATE user 
                    SET tbl_roles_id_role = 0
                    WHERE id = '$id'";
        
        mysqli_query($this->conn, $sql);
    }
    
    /**
     * Function to delete a user, very similar to suspend/restore
     * @param int $id the id of the user to be deleted
     * @return boolean whether the user was deleted
     */
    public function deleteUser(int $id)
    {
        $sql = "DELETE FROM user 
                WHERE id = '$id'";
        
        //die($sql);
        
        mysqli_query($this->conn, $sql);
        $success = (mysqli_affected_rows($this->conn) > 0);
        
        return $success;
    }
    
    /**
     * Function to check if a user is an admin
     * @param int $id the id of the user to examine
     * @return boolean whether the user is an admin
     */
    public function isAdmin(int $id)
    {
        $sql = "SELECT tbl_roles_id_role FROM user
                WHERE id = '$id'";
        
        $result = mysqli_query($this->conn, $sql);
        
        //Fetch the first row of the user and examine their role
        $row = $result->fetch_assoc();
        $role = $row['tbl_roles_id_role'];
        
        
        //mysqli_free_result($result);
        
        //Assume they are standard user
        if ($role == 2)
        {
            return true;
        }
        
        return false;
    }
    
    /**
     * Function to restore user
     * @param int $id the id of the user to restore
     */
    public function restoreUser(int $id)
    {
        $sql = "UPDATE user 
                SET tbl_roles_id_role = 1
                WHERE id = '$id'";
        
        mysqli_query($this->conn, $sql);
    }
    
    /**
     * function to get the id of a user, used for login
     * @param UserModel $user the user to search for
     * @return number| int 0 if not found, the matching id number otherwise
     */
    public function getUserID(UserModel $user)
    {
        //Not sure what a good unique key would be, I assume email is one
        $sql = "SELECT id FROM user
                WHERE email = '{$user->getEmail()}' AND password = '{$user->getPassword()}'";
        
        try 
        {
            $result = $this->conn->query($sql);
            $userID = 0;
            
            //If there are results, fetch id
            if (mysqli_num_rows($result) > 0)
            {
                //I don't remember if this is how you do it, but will find out I guess
                $row = mysqli_fetch_assoc($result);
                $userID = $row['id'];
            }
            //mysqli_free_result($result);
            
            return $userID;
        } 
        catch (Exception $e) {
            echo $e->getMessage();
        }
    }
    
    /**
     * function to get the details of the user
     * @param int $id the id of the user to search for 
     * @return \App\Models\UserModel the user
     */
    public function getUserDetails(int $id)
    {
        $sql = "SELECT * FROM user
                WHERE id = '$id'";
        
        $result = mysqli_query($this->conn, $sql);
        
        //Set user values from the result
        $user = new UserModel();
        $row = $result->fetch_assoc();
        
        $user->setName($row['name']);
        $user->setEmail($row['email']);
        $user->setPassword($row['password']);
        $user->setCity($row['city']);
        $user->setState($row['state']);
        $user->setField($row['field']);
        $user->setPicture($row['picture']);
        $user->setBio($row['bio']);
        $user->setWebLink($row['website']);
        $user->setIsSuspended($row['tbl_roles_id_role'] == 0);
        
        //mysqli_free_result($result);
        
        return $user;
    }
    
    /**
     * function to get all users
     * @return array|\App\Models\UserModel[] all non-admin users
     */
    public function getAllUsers()
    {
        $sql = "SELECT * FROM user WHERE tbl_roles_id_role != 2";
        
        //die($sql);
        
        $result = mysqli_query($this->conn, $sql);
        
        //Start with empty array of users
        $users = [];
        
        while ($row = $result->fetch_assoc())
        {
            //Add user details into instance
            $user = new UserModel();
            $user->setName($row['name']);
            $user->setEmail($row['email']);
            $user->setPassword($row['password']);
            $user->setIsSuspended($row['tbl_roles_id_role'] == 0);
            
            //have to create new Dao, want to fix this somehow
            $dao = new UserDataService($this->conn);
            
            $id = $dao->getUserID($user); 
            
            //die(print_r($row));
            
            //Add instance to the array, key is the id #
            $users += array($id => $user); 
        }
        
        //mysqli_free_result($result);
        
        return $users;
    }
    
    /**
     * Function to check if a user is suspended
     * @param $id int the id of the user to search for
     * @return boolean whether the user is suspended
     */
    public function isSuspended($id)
    {
        $sql = "SELECT tbl_roles_id_role FROM user 
                WHERE id = '$id'";
        
        //If their role id is 0, they are suspended
        //die($this->conn->ping());
        $result = $this->conn->query($sql);
        $row = $result->fetch_assoc();
        $isSuspended = $row['tbl_roles_id_role'] == 0;
        
        //mysqli_free_result($result);
        
        return $isSuspended;
    }
    
    //There is an item in the request table
    //It needs to be copied to the portfolio table
    
    public function approveRequest($id)
    {
        $sql = "SELECT (education_id, skill_id, history_id)
                FROM requests 
                WHERE id = '$id'";
        
        $educationID = -1;
        $historyID = -1;
        $skillID = -1;
        
        
        $result = $this->conn->query($sql);
        if ($result->num_rows > 0)
        {
            $row = $result->fetch_assoc();
            $educationID = $row['education_id'];
            $historyID = $row['history_id'];
            $skillID = $row['skill_id'];
        }
        else return false;
        
        $sql = "UPDATE portfolio 
                SET education_id = '$educationID',
                history_id = '$historyID',
                skill_id = '$skillID' 
                WHERE user_id = '$id'";
         
        $this->conn->query($sql);
        
        $sql = "DELETE FROM request
                WHERE user_id = '$id'";
        
        $this->conn->query($sql);
    }
    
    public function denyRequest($id)
    {
        $sql = "DELETE FROM request
                WHERE user_id = '$id'";
        
        $this->conn->query($sql);
    }
    
    /**
     * Function to get all requests from the request table
     * Note: This function does not return user data, just the ids
     * of the users with active requests.
     * Their data is collected in the business service, this might be horribly inneficient, I dunno
     */
    public function getAllRequests()
    {
        $sql = "SELECT user_id
                FROM request";
        
        $result = $this->conn->query($sql);
        
        $users = array();
        
        while ($row = $result->fetch_assoc())
        {
            $id = $row['user_id'];
            
            //Apparently using array_push takes longer, 
            //but the other methods I found were giving warnings, so I used it
            array_push($users, $id);
        }
        
        $this->conn->free_result();
        return $users;
    }
}