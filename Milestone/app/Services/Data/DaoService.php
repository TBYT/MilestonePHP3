<?php
namespace App\Services\Data;

use App\Models\UserModel;
use Exception;

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
    
    //TODO: Fix ER
    public function addUser(UserModel $user, bool $isAdmin)
    {   
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
    
    public function updateUser(int $id, UserModel $user)
    {
        $sql = "UPDATE user
                    SET name = '{$user->getName()}', email = '{$user->getEmail()}', 
                        password = '{$user->getPassword()}', bio = '{$user->getBio()}', 
                        website = '{$user->getWebLink()}', city = '{$user->getCity()}', 
                        state = '{$user->getState()}', field = '{$user->getField()}', 
                        picture = '{$user->getPicture()}'
                    WHERE id = '$id'";
        
        mysqli_query($this->conn, $sql);
        $success = mysqli_affected_rows($this->conn) > 0;
        mysqli_close($this->conn);
        return $success;
    }
    
    public function suspendUser(int $id)
    {
        $sql = "UPDATE user 
                    SET tbl_roles_id_role = 0
                    WHERE id = '$id'";
        
        mysqli_query($this->conn, $sql);
        mysqli_close($this->conn);
    }
    
    public function deleteUser(int $id)
    {
        $sql = "DELETE user 
                WHERE id = '$id'";
        
        mysqli_query($this->conn, $sql);
        $success = (mysqli_affected_rows($this->conn) > 0);
        mysqli_close($this->conn);
        
        return $success;
    }
    
    public function isAdmin(int $id)
    {
        $sql = "SELECT tbl_roles_id_role FROM user
                WHERE id = '$id'";
        
        $result = mysqli_query($this->conn, $sql);
        $row = $result->fetch_assoc();
        $role = $row['tbl_roles_id_role'];
        mysqli_free_result($result);
        mysqli_close($this->conn);
        
        if ($role == 2)
        {
            return true;
        }
        
        return false;
    }
    
    public function restoreUser(int $id)
    {
        $sql = "UPDATE user 
                SET tbl_roles_id_role = 1
                WHERE id = '$id'";
        
        mysqli_query($this->conn, $sql);
        mysqli_close($this->conn);
    }
    
    //Login Function
    public function getUserID(UserModel $user)
    {
        //Not sure what a good unique key would be, I assume email is one
        $sql = "SELECT id FROM user
                WHERE email = '{$user->getEmail()}' AND password = '{$user->getPassword()}'";
        
        //die($sql);
        
        $result = mysqli_query($this->conn, $sql);
        $userID = 0;
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
    
    public function getUserDetails(int $id)
    {
        $sql = "SELECT * FROM user
                WHERE id = '$id'";
        
        $result = mysqli_query($this->conn, $sql);
        
        //Shouldn't be more than one user
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
    
    public function getAllUsers()
    {
        $sql = "SELECT * FROM user WHERE tbl_roles_id_role != 2";
        
        //die($sql);
        
        $result = mysqli_query($this->conn, $sql);
        
        $users = [];
        
        while ($row = $result->fetch_assoc())
        {
            $user = new UserModel();
            $user->setName($row['name']);
            $user->setEmail($row['email']);
            $user->setPassword($row['password']);
            $user->setIsSuspended($row['tbl_roles_id_role'] == 0);
            
            $id = $this->getUserID($user); 
            
            //die(print_r($row));
            
            $users += array($id => $user); 
        }
        
        mysqli_free_result($result);
        //I don't know what happened to mysqli, but I can't run this...
        //mysqli_close($this->conn);
        
        //die(print_r($users));
        
        return $users;
    }
    
    public function isSuspended($id)
    {
        $sql = "SELECT tbl_roles_id_role FROM user 
                WHERE id = '$id'";
        
        $result = mysqli_query($this->conn, $sql);
        $row = $result->fetch_assoc();
        $isSuspended = $row['tbl_roles_id_role'] == 0;
        
        mysqli_free_result($result);
        mysqli_close($this->conn);
        
        return $isSuspended;
    }
}