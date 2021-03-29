<?php
/**
 * Author: Thomas Biegel
 * CST-256
 * 2.21.21
 */

namespace App\Http\Controllers;

use Illuminate\Routing\Controller as BaseController;
use App\Services\Business\BusinessService;
use App\Models\JobDTO;

class JobAPIController extends BaseController
{
    private $business;
    
    //Function for seeing all jobs
    public function index()
    {
        //Initialize the business layer
        $business = new BusinessService();
        
        //Retrieve all jobs from the database
        $jobs = $business->getAllJobs();
        
        //Default return
        $errorCode = 400;
        $errorMessage = "Could Not Retrieve Jobs From The Database";
        
        //If the database access method succeeded
        if ($jobs != null)
        {
            if (count($jobs) > 0)
            {
                $errorCode = 200;
                $errorMessage = "";
            }
        }
        
        //Data Transfer Object
        //TODO: make toString() method for a job model
        $dto = new JobDTO($errorCode, $errorMessage, print_r($jobs));
        
        //Return JSON data
        return $dto->jsonSerialize();
    }
    
    public function show($id)
    {
        //
        $business = new BusinessService();
        
        $job = $business->getJob($id);
        
        $errorCode = 402;
        $errorMessage = 'Could Not Retrieve The User From The Database';
        
        if ($job != false)
        {
            $errorCode = 200;
            $errorMessage = '';
        }
        
        $dto = new JobDTO($errorCode, $errorMessage, print_r($job));
        
        return $dto->jsonSerialize();
    }
}
