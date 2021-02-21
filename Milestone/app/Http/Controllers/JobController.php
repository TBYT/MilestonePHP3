<?php
/**
 * Author: Thomas Biegel
 * CST-256
 * 2.8.21
 */

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use App\Models\JobModel;
use App\Services\Business\JobBusinessService;

class JobController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    
    private $job;
    private $businessService;
    

    //Function to add a job
    public function add()
    {
        $this->businessService = new JobBusinessService();
        $this->job = new JobModel();
        
        $title = request()->get('title');
        $company = request()->get('company');
        $salary = request()->get('salary');
        $field = request()->get('field');
        $skills = request()->get('skills');
        $experience = request()->get('experience');
        $location = request()->get('location');
        $description = request()->get('description');
        
        $this->job->initialize($title, $company, $salary, $field, 
            $skills, $experience, $location, $description);
        
        $message = "Job could not be added. It may already exist"; 
        
        if ($this->businessService->add($this->job))
        {
            $message = "Job Added!";
        }
        $data =  ['message' => $message];
        return view('newjob')->with($data);
    }
}
