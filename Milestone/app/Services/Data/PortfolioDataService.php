<?php

/*
 * Author: Brian Basinger
 * 2.23.21
 * Portfolio DAO
 */

namespace App\Services\Data;

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
    
    /**
     * Function to add a portfolio to the database
     * @param int $id the id of the user to create the portfolio for
     * @return boolean whether the portfolio was successfuly added
     */
    public function addPortfolio($id)
    {
        $sql = "INSERT INTO portfolio
                (user_id)
                VALUES ('{$id}')";
        
        $this->conn->query($sql);
        
        return ($this->conn->affected_rows > 0);
    }
    
    //Not used
//     public function addPortfolioElements($id)
//     {
//         $sql1 = "INSERT INTO education
//                 (portfolio_id)
//                 VALUES ('{$id}')";
        
//         $result1 = $this->conn->query($sql1);
        
//         $sql2 = "INSERT INTO skills
//                 (portfolio_id)
//                 VALUES ('{$id}')";
        
//         $result2 = $this->conn->query($sql2);
        
//         $sql3 = "INSERT INTO history
//                 (portfolio_id)
//                 VALUES ('{$id}')";
        
//         $result3 = $this->conn->query($sql3);
        
//         if (mysqli_num_rows($result1) > 0 && mysqli_num_rows($result2) > 0 && mysqli_num_rows($result3) > 0)
//         {
//             $success = $this->conn->affected_rows > 0;
//         }
//         return $success;
//     }
    
    //Not used
//     public function getAllPortfolioUsers()
//     {
//         $sql = "SELECT user_id FROM portfolio";
        
//         $result = $this->conn->query($sql);
        
//         $ids = array();
        
//         while ($row = $result->fetch_assoc())
//         {
//             array_push($ids, $row['user_id']);
//         }
        
//         return $ids;
//     }
    
    //Not used
//     /**
//      * Search through portfolios
//      * @param string $pattern the pattern to search 
//      * @return array
//      */
//     public function searchPortfolioUsers(string $pattern)
//     {
//         $sql = "SELECT user_id FROM portfolio WHERE user.id = user_id ";
        
//         $result = $this->conn->query($sql);
        
//         $ids = array();
        
//         while ($row = $result->fetch_assoc())
//         {
//             array_push($ids, $row['user_id']);
//         }
        
//         return $ids;
//     }
        
        /**
         * gets the details of the specified portfolio
         * @param int $portid the id of the portfolio to retrieve
         * @return string[][]|string[][][] the education, history, and skills of the portfolio
         */
        public function getPortfolioDetails(int $portid)
        {
            //TODO: should be 3 functions?
            
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
            
            $lists = ['education' => $list1, 'skills' => $list2, 'history' => $list3];
            
            return $lists;
        }
  
        //Deprecated
//          /**
//          * Function to update user info
//          * @param int $id the id of the user to be updated
//          * @param PortfolioModel $user the portfolio model.
//          * @return boolean whether the user was updated
//          */
//         public function updatePortfolio(int $id, PortfolioModel $user)
//         {
//             //sql
//             $data = $user->getEducation()[0];
            
//             $sql1 = "UPDATE education
//                     SET start_date = '{$data['startdate']}', end_date = '{$data['enddate']}',
//                         institution = '{$data['institution']}', gpa = '{$data['gpa']}'
//                     WHERE portfolio_id = '$id'";
            
//             //Query statement, return whether it affects any rows
//             mysqli_query($this->conn, $sql1);
            
//             $success
            
//             //sql
//             $sql2 = "UPDATE history
//                         SET description = '{$user->getHistory()[0]}'
//                         WHERE portfolio_id = '$id'";
            
//             //Query statement, return whether it affects any rows
//             mysqli_query($this->conn, $sql2);
            
//             $sql3 = "UPDATE skills
//                     SET description = '{$user->getSkills()[0]}'
//                     WHERE portfolio_id = '$id'";
            
//             //Query statement, return whether it affects any rows
//             mysqli_query($this->conn, $sql3);
            
            
//             //TODO: This should only be successfuly if every transaction completes
//             $success = mysqli_affected_rows($this->conn) > 0;
            
//             return $success;
//        }
        
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
                    //fetch the row, then the id and return it
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
    
    /**
     * Add an empty education to the database
     * @param int $portfolioID the id of the portfolio to add the education to 
     */
    public function addEducation(int $portfolioID)
    {
        //TODO: return success/error? I didn't know if it was neccessary 
        //since the function should never fail assuming the logged in user is valid
        
        //Craft sql
        $sql = "INSERT INTO education
                (portfolio_id)
                VALUES ('$portfolioID')";
        
        //Query database
        mysqli_query($this->conn, $sql);
    }
    
    /**
     * Add an empty skill to the database
     * @param int $portfolioID the portfolio to add the skill to
     */
    public function addSkill(int $portfolioID)
    {
        //Craft sql
        $sql = "INSERT INTO skills
                (portfolio_id)
                VALUES ('$portfolioID')";
        
        //Query the database
        mysqli_query($this->conn, $sql);
    }
    
    /**
     * Add an empty history item to the database
     * @param int $portfolioID the portfolio to add the history to
     */
    public function addHistory(int $portfolioID)
    {
        //Craft sql
        $sql = "INSERT INTO history
                (portfolio_id)
                VALUES ('$portfolioID')";
        
        //Query database
        mysqli_query($this->conn, $sql);
    }
    
    /**
     * Function to delete an education
     * @param string $insitution the institution to be deleted
     * @param int $portfolioID the id of the portfolio to update
     * @return boolean whether the transaction was successful
     */
    public function deleteEducation(string $institution, int $portfolioID)
    {
        //Craft sql
        $sql = "DELETE FROM education 
                    WHERE `institution` = '$institution'
                    AND `portfolio_id` = '$portfolioID'
                    LIMIT 1";
        
        //Query the database
        $this->conn->query($sql);
        
        //Return if the database was updated
        return ($this->conn->affected_rows > 0);
    }
    
    /**
     * Function to delete a job history
     * @param string $skill the job history to be deleted
     * @param int $portfolioID the id of the portfolio to update
     * @return boolean whether the transaction was successful
     */
    public function deleteHistory(string $history, int $portfolioID)
    {
        //Craft sql
        $sql = "DELETE FROM history
                    WHERE `description` = '$history'
                    AND `portfolio_id` = '$portfolioID'
                    LIMIT 1";
        
        //Query Database
        $this->conn->query($sql);
        
        //Return whether the database was updated
        return ($this->conn->affected_rows > 0);
    }
    
    /**
     * Function to delete a skill
     * @param string $skill the skill to be deleted
     * @param int $portfolioID the id of the portfolio to update
     * @return boolean whether the transaction was successful
     */
    public function deleteSkill(string $skill, int $portfolioID)
    {
        //Craft sql
        $sql = "DELETE FROM skills
                    WHERE `description` = '$skill' 
                    AND `portfolio_id` = '$portfolioID'
                    LIMIT 1";
        
        //Query Database
        $this->conn->query($sql);
        
        //Return if the database was updated
        return ($this->conn->affected_rows > 0);
    }
    
    /**
     * Function to update a specific education
     * @param string $oldDesc the old institution for the education
     * @param array $newDesc the updated education
     * @param int $portfolioID the id of the portfolio to be updated
     * @return boolean whether the transaction was successful
     */
    public function updateEducation(string $oldInstitution, array $education, int $portfolioID)
    {
        //Craft sql
        //TODO: limit 1?
        $sql = "UPDATE education
                    SET `institution` = '{$education['institution']}',
                    `start_date` = '{$education['startdate']}',
                    `end_date` = '{$education['enddate']}',
                    `gpa` = '{$education['gpa']}'
                    WHERE `institution` = '$oldInstitution'
                    AND `portfolio_id` = '$portfolioID'";
        
        //Query the database
        $this->conn->query($sql);
        
        //Return if the database was updated
        return ($this->conn->affected_rows > 0);
    }
    
    /**
     * Function to update a specific job history
     * @param string $oldDesc the old description for the history
     * @param string $newDesc the updated description
     * @param int $portfolioID the id of the portfolio to be updated
     * @return boolean whether the transaction was successful
     */
    public function updateHistory(string $oldDesc, string $newDesc, int $portfolioID)
    {
        //TODO: all update functions are very similar... 
        //maybe merge like the search function?
        
        //Craft sql
        //TODO: limit 1?
        $sql = "UPDATE history
                    SET `description` = '$newDesc'
                    WHERE `description` = '$oldDesc'
                    AND `portfolio_id` = '$portfolioID'";
       
        //Query database
        $this->conn->query($sql);
        
        //Return whether the database was updated
        return ($this->conn->affected_rows > 0);
    }
    
    /**
     * Function to update a specific skill
     * @param string $oldDesc the old description for the skill
     * @param string $newDesc the updated description
     * @param int $portfolioID the id of the portfolio to be updated
     * @return boolean whether the transaction was successful
     */
    public function updateSkill(string $oldDesc, string $newDesc, int $portfolioID)
    {
        //Craft sql
        //TODO: limit 1?
        $sql = "UPDATE skills
                    SET `description` = '$newDesc'
                    WHERE `description` = '$oldDesc'
                    AND `portfolio_id` = '$portfolioID'";
        
        //Query sql
        $this->conn->query($sql);
        
        //Return whether the database was updated
        return ($this->conn->affected_rows > 0);
    }
}
