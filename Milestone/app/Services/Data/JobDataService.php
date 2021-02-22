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
        $sql = "INSERT INTO jobs 
                (title, company, salary, field, skills, 
                    experience, location, description) 
                VALUES ('{$job->getTitle()}', '{$job->getCompany()}', '{$job->getSalary()}',
                    '{$job->getField()}', '{$job->getSkills()}', '{$job->getExperience()}',
                    '{$job->getLocation()}', '{$job->getDescription()}')";
        
        $this->conn->query($sql);
        $success = $this->conn->affected_rows > 0;
        return $success;
    }
}

