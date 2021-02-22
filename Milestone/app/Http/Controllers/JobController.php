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
use App\Models\JobModel;
use App\Services\Business\BusinessService;

class JobController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    
    private $job;
    private $businessService;
    

    //Function to add a job
    public function add()
    {
        $this->businessService = new BusinessService();
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
        
        if ($this->businessService->addJob($this->job))
        {
            $message = "Job Added!";
        }
        $data =  ['message' => $message];
        return view('admin\newjob')->with($data);
    }
    
    public function showAll()
    {
        $this->businessService = new BusinessService();
        $jobs = $this->businessService->getAllJobs();
        
        $data = ['jobs' => $jobs];
        //Feels... Good. Man
        return view('admin\alljobs')->with($data);
    }
    
    public function delete()
    {
        $this->businessService = new BusinessService();
        $this->businessService->deleteJob(request()->get('id'));
        
        $jobs = $this->businessService->getAllJobs();
        
        $data = [
            'jobs' => $jobs,
            'message' => 'Job Deleted!'
        ];
        
        return view('admin\alljobs')->with($data);
    }
    
    public function doEdit()
    {
        $this->businessService = new BusinessService();
        
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
        
        $success = $this->businessService->editJob($this->job, request()->get('id'));
        
        $jobs = $this->businessService->getAllJobs();
        
        $message = 'Job could not be updated';
        if ($success)
        {
            $message = 'Job Updated';
        }
        
        $data = [
            'jobs' => $jobs,
            'message' => $message
        ];
        
        return view('admin\alljobs')->with($data);
    }
    
    public function edit()
    {
        $this->businessService = new BusinessService();
        $this->job = $this->businessService->getJob(request()->get('id'));
        
        //Should use flash here, but I am lazy and don't have a lot of practice with it
        $data = [
            'job' => $this->job,
            'id' => request()->get('id')
        ];
        
        return view('admin\editjob')->with($data);
    }
}
