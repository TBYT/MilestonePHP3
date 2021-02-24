<?php

/*
 * Author: Brian Basinger
 * 2.23.21
 * Portfolio DAO
 */

namespace App\Services\Data;

use App\Models\PortfolioModel;
use Exception;

class PortfolioDataService
{
    private $conn;
    
    public function __construct($conn)
    {
        $this->conn = $conn;
    }
    
//     /**
//      * Function to add an empty portfolio to the database
//      * @param int $userID the id of the user whose portfolio is being added
//      * @return bool whether the entry was added successfuly
//      */
//     public function addPortfolio(int $userID)
//     {
//         //Create sql
        
//         //Query SQL
        
//         //Return true if the data was added
//         return true;
//     }
    
//     /**
//      * 
//      * @param string $education the education to be added. NB: This will need to be changed to an education model if you are using one
//      * @param int $portfolioID the id of the portfolio to which an entry is being added
//      * @return boolean whether the entry was added successfuly
//      */
//     public function addEducation(string $education, int $portfolioID)
//     {
//         //Create sql
        
//         //Query SQL
        
//         //Return true if the data was added
//         return true;
//     }
    
//     /**
//      * 
//      * @param string $experience the data to be added
//      * @param int $portfolioID the id of the portfolio to which an entry is being added
//      * @return boolean whether the entry was added successfuly
//      */
//     public function addExperience(string $experience, int $portfolioID)
//     {
//         //Create sql
        
//         //Query SQL
        
//         //Return true if the data was added
//         return true;
//     }
    
//     /**
//      * Adds a history
//      * @param string $history the data to be added
//      * @param int $portfolioID the id of the portfolio to which an entry is being added
//      * @return boolean whether the entry was added successfuly
//      */
//     public function addHistory(string $history, int $portfolioID)
//     {
//         //Create sql
        
//         //Query SQL
        
//         //Return true if the data was added
//         return true;
//     }
    
    public function addPortfolio($id)
    {
        $sql = "INSERT INTO portfolio
                (user_id)
                VALUES ('{$id}')";
        
        $this->conn->query($sql);
        if ($this->conn->affected_rows > 0)
        {
            $success = addPortfolioElements($id);
        }
        //else, we havent add rollback feature yet, so we hope this does not fail.
        return $success;
    }
    
    public function addPortfolioElements($id)
    {
        $sql1 = "INSERT INTO education
                (portfolio_id)
                VALUES ('{$id}')";
        
        $result1 = $this->conn->query($sql1);
        
        $sql2 = "INSERT INTO skills
                (portfolio_id)
                VALUES ('{$id}')";
        
        $result2 = $this->conn->query($sql2);
        
        $sql3 = "INSERT INTO history
                (portfolio_id)
                VALUES ('{$id}')";
        
        $result3 = $this->conn->query($sql3);
        
        if (mysqli_num_rows($result1) > 0 && mysqli_num_rows($result2) > 0 && mysqli_num_rows($result3) > 0)
        {
            $success = $this->conn->affected_rows > 0;
        }
        return $success;
    }
    
    public function getAllPortfolioUsers()
    {
        $sql = "SELECT user_id FROM portfolio";
        
        $result = $this->conn->query($sql);
        
        $ids = array();
        
        while ($row = $result->fetch_assoc())
        {
            array_push($ids, $row['user_id']);
        }
        
        return $ids;
    }
    
    public function searchPortfolioUsers(string $pattern)
    {
        $sql = "SELECT user_id FROM portfolio WHERE user.id = user_id ";
        
        $result = $this->conn->query($sql);
        
        $ids = array();
        
        while ($row = $result->fetch_assoc())
        {
            array_push($ids, $row['user_id']);
        }
        
        return $ids;
    }
        
        /*
         * Method to return portfolio details for a user.
         * Or createa a new portfolio if there are no details retrieved from a resultset.
         */
        public function getPortfolioDetails($id, $portid)
        {
            //Query the row and storing data in a list.
            $educationSQL = "SELECT * FROM education WHERE portfolio_id
                = '$portid'";
            
            $result = $this->conn->query($educationSQL);
            
            $list1 = array(); //an array because we wanted to implement multiple educations for a user, but have not yet done so.
            $index = 0;
            while ($row = $result->fetch_assoc())
            {
                $education = array();
                $education['startdate'] = $row['start_date'];
                $education['enddate'] = $row['end_date'];
                $education['institution'] = $row['institution'];
                $education['gpa'] = $row['gpa'];
                $list1[$index] = $education;
                $index++;
            }
            
            //Query the row and storing data in a list.
            $sql2 = "SELECT description FROM skills
                WHERE portfolio_id
                = '$portid'";
            
            $result2 = $this->conn->query($sql2);
            $list2 = array(); //an array because we wanted to implement multiple skills for a user, but have not yet done so.
            $index = 0;
            while ($row = $result2->fetch_assoc())
            {
                $skills = $row['description'];
                $list2[$index] = $skills;
                $index++;
            }
            
            //Query the row and storing data in a list.
            $sql3 = "SELECT description FROM history
                WHERE portfolio_id
                = '$portid'";
            
            $result3 = $this->conn->query($sql3);
            $list3 = array(); //an array because we wanted to implement multiple job experience for a user, but have not yet done so.
            $index = 0;
            while ($row = $result3->fetch_assoc())
            {
                $history = $row['description'];
                //die("Adding History: " . $row['description']);
                $list3[$index] = $history;
                $index++;
            }
            
            //die("rows: " . $this->conn->affected_rows);
            // if there was no data returned at all, we create a new portfolio.
            if ($this->conn->affected_rows == 0)
            {
                $sql = "INSERT INTO portfolio
                (user_id)
                VALUES ('{$id}')";
                
                //die($sql);
                
                //$this->conn->query($sql);
                mysqli_query($this->conn, $sql);
                
                $newportid = $this->getPortfolioID($id); //get the newly made portfolio id from the user.
                
                $sql1 = "INSERT INTO education
                (portfolio_id)
                VALUES ('{$newportid}')";
                
                mysqli_query($this->conn, $sql1);
                
                $sql2 = "INSERT INTO skills
                (portfolio_id)
                VALUES ('{$newportid}')";
                
                mysqli_query($this->conn, $sql2);
                
                $sql3 = "INSERT INTO history
                (portfolio_id)
                VALUES ('{$newportid}')";
                
                mysqli_query($this->conn, $sql3);
                
                //die($sql1 . "\t" . $sql2 . "\t" . $sql3);
                
                $education = array();
                $education['startdate'] = "";
                $education['enddate'] = "";
                $education['institution'] = "";
                $education['gpa'] = "";
                $list1[0] = $education; //education list, of education details.
                
                $skills = "";
                $list2[0] = $skills; //skills list
                
                $history = "";
                $list3[0] = $history; //history list
            }
            
            $lists = ['education' => $list1, 'skills' => $list2, 'history' => $list3];
            
            return $lists;
        }
        
        /**
         * Function to update user info
         * @param int $id the id of the user to be updated
         * @param PortfolioModel $user the portfolio model.
         * @return boolean whether the user was updated
         */
        public function updatePortfolio(int $id, PortfolioModel $user)
        {
            //sql
            //$data = array();
            $data = $user->getEducation()[0];
            
            //die("Education: " . print_r($data) . " History: " . print_r($user->getHistory()) . " Skills: " . print_r($user->getSkills()));
            //die(print_r($data));
            $sql1 = "UPDATE education
                    SET start_date = '{$data['startdate']}', end_date = '{$data['enddate']}',
                        institution = '{$data['institution']}', gpa = '{$data['gpa']}'
                    WHERE portfolio_id = '$id'";
            
            //Query statement, return whether it affects any rows
            mysqli_query($this->conn, $sql1);
            
            //sql
            $sql2 = "UPDATE history
                        SET description = '{$user->getHistory()[0]}'
                        WHERE portfolio_id = '$id'";
            
            //Query statement, return whether it affects any rows
            mysqli_query($this->conn, $sql2);
            
            $sql3 = "UPDATE skills
                    SET description = '{$user->getSkills()[0]}'
                    WHERE portfolio_id = '$id'";
            
            //Query statement, return whether it affects any rows
            mysqli_query($this->conn, $sql3);
            
            
            $success = mysqli_affected_rows($this->conn) > 0;
            
            return $success;
        }
        
        /**
         * function to get the id of a user, used for login
         * @param $id $user the user to search for
         * @return number| int 0 if not found, the matching id number otherwise
         */
        public function getPortfolioID($id)
        {
            //Not sure what a good unique key would be, I assume email is one
            $sql = "SELECT id FROM portfolio
                WHERE user_id = '$id'";
            
            try
            {
                $result = $this->conn->query($sql);
                $portID = 0;
                
                //If there are results, fetch id
                if (mysqli_num_rows($result) > 0)
                {
                    //I don't remember if this is how you do it, but will find out I guess
                    $row = mysqli_fetch_assoc($result);
                    $portID = $row['id'];
                }
                //mysqli_free_result($result);
                
                return $portID;
            }
            catch (Exception $e) {
                echo $e->getMessage();
            }
        }
}
