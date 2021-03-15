<?php

/*
 * Job DAO
 * Author:Thomas Biegel
 * 2.21.21
 */

namespace App\Services\Data;

use App\Models\JobModel;

class JobDataService
{
    private $conn;
    
    public function __construct($conn)
    {
        $this->conn = $conn;
    }
    
    /**
     * Add a new job into the database
     * @param JobModel $job the job to be added
     * @return boolean whether the job was successfuly added
     */
    public function addJob(JobModel $job)
    {
        //Craft sql
        $sql = "INSERT INTO job
                (title, company, salary, field, skills, 
                    experience, location, description) 
                VALUES ('{$job->getTitle()}', '{$job->getCompany()}', '{$job->getSalary()}',
                    '{$job->getField()}', '{$job->getSkills()}', '{$job->getExperience()}',
                    '{$job->getLocation()}', '{$job->getDescription()}')";
        
        //die($sql);
        
        $this->conn->query($sql);
        
        //If the number of rows affected is greater than 0, return true
        $success = $this->conn->affected_rows > 0;
        return $success;
    }
    
    /**
     * Method to return all jobs in the database
     * @return \App\Models\JobModel[]
     */
    public function getAllJobs()
    {
        $sql = "SELECT * FROM job";
        
        $result = $this->conn->query($sql);
        
        //Create array to be returned
        $jobs = array();
        
        //For each item in the resultList
        while ($row = $result->fetch_assoc())
        {
            //Initialize job fields
            $job = new JobModel();
            $job->setTitle($row['title']);
            $job->setField($row['field']);
            $job->setSkills($row['skills']);
            $job->setExperience($row['experience']);
            $job->setLocation($row['location']);
            $job->setDescription($row['description']);
            $job->setCompany($row['company']);
            $job->setSalary($row['salary']);
            
            //Add job to the array, with its id as the index
            $jobs[$row['id']] = $job;
        }
        
        //Free the result and return the array
        mysqli_free_result($result);
        return $jobs;
    }
    
    /**
     * Delete a job
     * @param int $id the id of the job to be deleted
     */
    public function deleteJob(int $id)
    {
        $sql = "DELETE FROM job
                WHERE id = '$id'";
        
        $this->conn->query($sql);
    }
    
    /**
     * Get a jobs details
     * @param int $id the id of the job to find
     * @return \App\Models\JobModel the details of the job
     */
    public function findByID(int $id)
    {
        $sql = "SELECT * FROM job
                WHERE id = '$id'";
        
        $result = $this->conn->query($sql);
        
        $job = new JobModel();
        
        //While statement is unneccessary because there is 
        //Only one result, but functions the same
        while ($row = $result->fetch_assoc())
        {
            //Intialize job fields
            $job->setTitle($row['title']);
            $job->setCompany($row['company']);
            $job->setSalary($row['salary']);
            $job->setField($row['field']);
            $job->setSkills($row['skills']);
            $job->setExperience($row['experience']);
            $job->setLocation($row['location']);
            $job->setDescription($row['description']);
        }
        
        return $job;
    }
    
    /**
     * Update one job
     * @param JobModel $job the new job details
     * @param int $id the id of the job to be edited
     * @return boolean whether the job was successfuly edited
     */
    public function updateJob(JobModel $job, int $id)
    {
        $sql = "UPDATE job 
                SET title = '{$job->getTitle()}', company = '{$job->getcompany()}',
                salary = '{$job->getSalary()}', field = '{$job->getField()}',
                skills = '{$job->getSkills()}', experience = '{$job->getExperience()}',
                location = '{$job->getLocation()}', description = '{$job->getDescription()}'
                WHERE id = '$id'";
        
        $this->conn->query($sql);
        
        //If no rows were effected, the data was not inserted
        return ($this->conn->affected_rows > 0);
    }
    
    /**
     * Searches the database for similar results
     * @param string $searchTerm the property to search by
     * @param string $pattern the text of the property
     * @return \App\Models\JobModel[] list of results
     */
    public function search(string $searchTerm, string $pattern)
    {
        //search term is the collumn name, pattern is its value
        $sql = "SELECT * FROM `job`
                WHERE $searchTerm LIKE '%$pattern%'";
        
        //die($sql);
        
        $result = $this->conn->query($sql);
        
        //Create array to be returned
        $jobs = array();
        
        //For each index in the array
        while ($row = $result->fetch_assoc())
        {
            //Initialize new job and its fields
            
            
                $job = new JobModel();
                $job->setTitle($row['title']);
                $job->setField($row['field']);
                $job->setSkills($row['skills']);
                $job->setExperience($row['experience']);
                $job->setLocation($row['location']);
                $job->setDescription($row['description']);
                $job->setCompany($row['company']);
                $job->setSalary($row['salary']);
                
                //Put the job into the array with its id as an index
                $jobs[$row['id']] = $job;
        }
            
        //Free the result and return the array
        mysqli_free_result($result);
        
        return $jobs;
    }
    
    public function apply(int $userID, int $jobid)
    {
        $sql = "INSERT INTO application (`user`, `job`)
                    VALUES('$userID', '$jobid')";
        
        //die($sql);
        
        $this->conn->query($sql);
        //If the number of rows affected is greater than 0, return true
        $success = $this->conn->affected_rows > 0;
        return $success;
    }
    
    public function appliedJobs($id)
    {
        $sql = "SELECT * FROM application
                    WHERE `user` = '$id'";
        
        $result = $this->conn->query($sql);
        
        $jobs = array();
        
        $counter = 0;
        while ($row = $result->fetch_assoc())
        {
            //$appid = $row['id'];
            //$user = $row['user'];
            $job = $row['job'];
            //$details = [ $user, $job ];
            $jobs[$counter] = $job;
            $counter++;
        }
        //Free the result and return the array
        mysqli_free_result($result);
        
        return $jobs;
    }
}

