<?php
namespace App\Services\Data;

use App\Models\UserModel;
use Exception;
use Symfony\Component\CssSelector\Parser\Token;
use Symfony\Polyfill\Intl\Idn\Info;
use PhpParser\Node\Stmt\For_;

//Data Access Class
class DaoService
{
    //Define the connection string
    //TODO: needs to be changed to reflect hosting site
    private $conn;
    private $servername = "localhost";
    private $username = "root";
    private $password = "root";
    
    //These 2 might need to be changed
    private $dbname = "dbcst256";
    private $port = 3306;
    
    private $dbQuery;
    
    //Constructor that creates a connection with the database
    public function __construct()
    {
        //Create a connection to the database
        $this->conn = mysqli_connect($this->servername, $this->username, $this->password, $this->dbname);
        
        //Make sure to always test the connection and see if there are any errors.
        if ($this->conn == false || $this->conn == null)
        {
            die(mysqli_error($this->conn));
        }
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
      
        mysqli_close($this->conn);
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
        mysqli_close($this->conn);
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
        mysqli_close($this->conn);
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
        
       // die($sql);
        
        mysqli_query($this->conn, $sql);
        $success = (mysqli_affected_rows($this->conn) > 0);
        mysqli_close($this->conn);
        
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
        
        
        mysqli_free_result($result);
        mysqli_close($this->conn);
        
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
        mysqli_close($this->conn);
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
        
        //die($sql);
        
        //Search for user, assume one is not found
        $result = mysqli_query($this->conn, $sql);
        $userID = 0;
        
        //If there are results, fetch id
        if (mysqli_num_rows($result) > 0)
        {
            //I don't remember if this is how you do it, but will find out I guess
            $row = mysqli_fetch_assoc($result);
            $userID = $row['id'];
        }
        mysqli_free_result($result);
        mysqli_close($this->conn);
        
        return $userID;
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
        
        mysqli_free_result($result);
        mysqli_close($this->conn);
        
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
            $dao = new DaoService();
            
            $id = $dao->getUserID($user); 
            
            //die(print_r($row));
            
            //Add instance to the array, key is the id #
            $users += array($id => $user); 
        }
        
        mysqli_free_result($result);
        //I don't know what happened to mysqli, but I can't run this...
        //mysqli_close($this->conn);
        
        //die(print_r($users));
        
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
        $result = mysqli_query($this->conn, $sql);
        $row = $result->fetch_assoc();
        $isSuspended = $row['tbl_roles_id_role'] == 0;
        
        mysqli_free_result($result);
        mysqli_close($this->conn);
        
        return $isSuspended;
    }
}