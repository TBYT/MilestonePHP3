<?php
namespace App\Services\Data;

use App\Services\Data\Utility\DataAccess;
use App\Models\JobModel;

class JobDataService
{
    private $dbname = "dbcst256";
    private $conn;
    
    public function __construct($conn)
    {
        $this->conn = $conn;
    }
    
    public function addJob(JobModel $job)
    {
        $sql = "INSERT INTO job
                (title, company, salary, field, skills, 
                    experience, location, description) 
                VALUES ('{$job->getTitle()}', '{$job->getCompany()}', '{$job->getSalary()}',
                    '{$job->getField()}', '{$job->getSkills()}', '{$job->getExperience()}',
                    '{$job->getLocation()}', '{$job->getDescription()}')";
        
        $this->conn->query($sql);
        $success = $this->conn->affected_rows > 0;
        return $success;
    }
    
    public function getAllJobs()
    {
        $sql = "SELECT * FROM job";
        
        $result = $this->conn->query($sql);
        
        $jobs = array();
        
        while ($row = $result->fetch_assoc())
        {
            $job = new JobModel();
            $job->setTitle($row['title']);
            $job->setField($row['field']);
            $job->setSkills($row['skills']);
            $job->setExperience($row['experience']);
            $job->setLocation($row['location']);
            $job->setDescription($row['description']);
            $job->setCompany($row['company']);
            $job->setSalary($row['salary']);
            
            $jobs[$row['id']] = $job;
        }
        
        mysqli_free_result($result);
        
        return $jobs;
    }
    
    public function deleteJob(int $id)
    {
        $sql = "DELETE FROM job
                WHERE id = '$id'";
        
        $this->conn->query($sql);
    }
    
    public function findByID(int $id)
    {
        $sql = "SELECT * FROM job
                WHERE id = '$id'";
        
        $result = $this->conn->query($sql);
        
        $job = new JobModel();
        
        while ($row = $result->fetch_assoc())
        {
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
    
    public function updateJob(JobModel $job, int $id)
    {
        $sql = "UPDATE job 
                SET title = '{$job->getTitle()}', company = '{$job->getcompany()}',
                salary = '{$job->getSalary()}', field = '{$job->getField()}',
                skills = '{$job->getSkills()}', experience = '{$job->getExperience()}',
                location = '{$job->getLocation()}', description = '{$job->getDescription()}'";
        
        $this->conn->query($sql);
        
        return ($this->conn->affected_rows > 0);
    }
}

