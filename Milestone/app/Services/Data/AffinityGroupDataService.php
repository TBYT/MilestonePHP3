<?php

/*
 * Job DAO
 * Author:Thomas Biegel
 * 2.21.21
 */

namespace App\Services\Data;

class AffinityGroupDataService {
    private $conn;
    
    //AFFINITY TABLE
    //Replace 'affinity' with table name
    //Replace 'name' with row for group name
    //Replace 'description' with row for description
    
    //LINKING TABLE
    //Replace 'usergroups with table connecting users and AG
    //Replace 'affinity_id' with the fk for affinity table
    //Replace 'users_id' with the fk for the user table
    
    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    public function addGroup(string $group, string $description)
    {
        $sql = "INSERT INTO affinity 
                    (name, description) 
                    VALUES ('$group', '$description')";

        
        //die($sql);
        
        $this->conn->query($sql);
        
        $success = ($this->conn->affected_rows > 0);
        
        return $success;
    }
    
    public function getGroupDetails(int $id)
    {
        $sql = "SELECT name, description FROM affinity WHERE id = '$id' LIMIT 1";
        
        $result = $this->conn->query($sql);
        
        $row = $result->fetch_assoc();
        
        $name = $row['name'];
        $description = $row['description'];
        
        $group = ['name' => $name, 'description' => $description];
        
        return $group;
    }
    
    public function getAllUsers(int $id)
    {
        $sql = "SELECT * FROM usergroups 
                    WHERE `affinity_id` = '$id'";
        
        $result = $this->conn->query($sql);
        
        $userIDs = array();
        
        while ($row = $result->fetch_assoc())
        {
            $userID = $row['users_id'];
            array_push($userIDs, $userID);
        }
        
        return $userIDs;
    }
    
    public function userInGroup(int $userID, int $id)
    {
        $sql = "SELECT id FROM usergroups WHERE `users_id` = '$userID' AND `affinity_id` = '$id'";
        
        $result = $this->conn->query($sql);
        
        return ($result->num_rows > 0);
    }
    
    public function deleteGroup(int $id)
    {
        $sql = "DELETE FROM affinity WHERE id = '$id'";
        
        $this->conn->query($sql);
        
        return ($this->conn->affected_rows > 0);
    }
    
    public function updateGroup(int $id,string $name,string $desc)
    {
        $sql = "UPDATE affinity SET `name` = '$name', `description` = '$desc'
                    WHERE `id` = '$id'";
        
        $this->conn->query($sql);
        
        return ($this->conn->affected_rows > 0);
    }
    
    public function joinGroup(int $userID, int $id)
    {
        $sql = "INSERT INTO usergroups (`users_id`, `affinity_id`)
                    VALUES('$userID', '$id')";
        
        $this->conn->query($sql);
        
        return ($this->conn->affected_rows > 0);
    }
    
    public function leaveGroup(int $userID, int $id)
    {
        $sql = "DELETE FROM usergroups WHERE `users_id` = '$userID' AND `affinity_id` = '$id'";
        
        $this->conn->query($sql);
        
        return ($this->conn->affected_rows > 0);
    }
    
    public function getAll()
    {
        $sql = "SELECT * FROM affinity";
        
        $result = $this->conn->query($sql);
        
        $groups = array();
        
        while ($row = $result->fetch_assoc())
        {
            $id = $row['id'];
            $name = $row['name'];
            $description = $row['description'];
            $details = [$name, $description];
            $groups[$id] = $details;
        }
        
        return $groups;
    }
    
    public function getByID(int $id)
    {
        $sql = "SELECT * FROM affinity
                    WHERE `id` = '$id'";
        
        $result = $this->conn->query($sql);
        
        $row = $result->fetch_assoc();
        $name = $row['name'];
        $description = $row['description'];
        $details = [
            $name,
            $description
        ];
        
        return $details;
    }
}