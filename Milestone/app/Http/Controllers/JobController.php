<?php
/**
 * Author: Thomas Biegel
 * CST-256
 * 2.21.21
 */

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use App\Models\JobModel;
use App\Services\Business\BusinessService;
use App\Services\Data\Utility\ILoggerService;
use Carbon\Exceptions\Exception;
//use App\Services\Business\PrivilegeCheck;

class JobController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    
    private $job;
    private $businessService;
    
    protected $logger;
    
    public function __construct(ILoggerService $logger)
    {
        $this->logger = $logger;
    }

    //Function to add a job
    public function add()
    {
        //Initialize business service and job
        $this->businessService = new BusinessService();
        $this->job = new JobModel();
        
        $this->validateForm(request());
        
        //Fill job data
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
        
        //default result is error
        $message = "Job could not be added. It may already exist"; 
        
        try {
        //Try to add the job
        if ($this->businessService->addJob($this->job))
        {
            $message = "Job Added!";
        }
        }
        catch (Exception $e)
        {
            $this->logger->error("Something went wrong with adding a job: "+$e);
        }
        
        //Return view
        $data =  ['message' => $message];
        return view('admin\newjob')->with($data);
    }
    
    //Function to show all jobs to the admin
    public function showAll()
    {
        //$this->pc = new PrivilegeCheck();
        
        $this->businessService = new BusinessService();
        try {
        $jobs = $this->businessService->getAllJobs();
        }
        catch (Exception $e)
        {
            $this->logger->error("Something went wrong with showing all jobs: "+$e);
        }
        
        $data = ['jobs' => $jobs,];
        //die (print_r($data));
        //Feels... Good. Man
        //return view('admin\alljobs')->with($data);
        return view('admin\alljobs')->with($data);
    }
    
    //Function to delete a job
    public function delete()
    {
        //Initialize business service and delete job
        $this->businessService = new BusinessService();
        try {
        $this->businessService->deleteJob(request()->get('id'));
        
        //Rerun the get all jobs page wtih updated list of jobs
        $jobs = $this->businessService->getAllJobs();
        }
        catch (Exception $e)
        {
            $this->logger->error("Something went wrong with deleting a job: "+$e);
        }
        $data = [
            'jobs' => $jobs,
            'message' => 'Job Deleted!'
        ];
        
        return view('admin\alljobs')->with($data);
    }
    
    
    //Function to edit a job's details
    public function doEdit()
    {
        //Initialize business layer and job 
        $this->businessService = new BusinessService();
        
        $this->job = new JobModel();
        
        //Validate 
        $this->validateForm(request());
        
        //Fill job details
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
        
        try {
        //Run business layer function
        $success = $this->businessService->editJob($this->job, request()->get('id'));
        
        //Return the show all jobs page
        $jobs = $this->businessService->getAllJobs();
        }
        catch (Exception $e)
        {
            $this->logger->error("Something went wrong with editing a job: "+$e);
        }
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
    
    //Function to edit a job
    public function edit()
    {
        //Initialize the business layer and job
        $this->businessService = new BusinessService();
        try {
        $this->job = $this->businessService->getJob(request()->get('id'));
        }
        catch (Exception $e)
        {
            $this->logger->error("Something went wrong with editing a job: "+$e);
        }
        //Should use flash here, but I am lazy and don't have a lot of practice with it
        $data = [
            'job' => $this->job,
            'id' => request()->get('id')
        ];
        
        return view('admin\editjob')->with($data);
    }
    
    //Function to search for jobs
    public function search()
    {
        //Initialize business layer
        $this->businessService = new BusinessService();
        
        $rules = [
            'title' => 'Required_Without_All:salary,field,location,experience,company',
        ];
        
        //Run Data Validation Rules
        $this->validate(request(), $rules);
        
        //If the fields aren't filled, they will be null
        $properties = [
            'title'=>request()->get('title'),
            'company'=>request()->get('company'),
            'salary'=>request()->get('salary'),
            'field' => request()->get('field'),
            'experience' => request()->get('experience'),
            'location' => request()->get('location'),
        ];
        
        try {
        //Run the search method
        $jobs = $this->businessService->searchJobs($properties);
        }
        catch (Exception $e)
        {
            $this->logger->error("Something went wrong with searching a job: "+$e);
        }
        $message = "Search Results";
        
        if (count($jobs) == 0)
        {
            $message = "No Results";
        }
        
        $data = 
        [
            'jobs' => $jobs,
            'message' => $message,
        ];
        
        //die(print_r($jobs));
        
        //Return results
        return redirect('jobsearch')->with($data);
        
    }
    
    public function view()
    {
        //Initialize the business layer and job
        $this->businessService = new BusinessService();
        try {
        $this->job = $this->businessService->getJob(request()->get('id'));
        }
        catch (Exception $e)
        {
            $this->logger->error("Something went wrong with viewing a job: "+$e);
        }
        //Should use flash here, but I am lazy and don't have a lot of practice with it
        $data = [
            'job' => $this->job,
            'id' => request()->get('id')
        ];
        
        return view('viewjob')->with($data);
    }
    
    private function validateForm(Request $request)
    {
        $rules = [
            'title' => 'Required | Between: 8,30 | Alpha',
            'company' => 'Required | Between: 4, 10',
            'salary' => 'Required | Alpha_Num | Between: 4, 7',
            'field' => 'Required | Between: 5,30 | Alpha',
            'skills' => 'Required | Between: 8,30 | Alpha',
            'experience' => 'Required | Between: 2,20| Alpha_Num',
            'location' => 'Required | Between: 5,30 | Alpha',
            'description' => 'Required | Between: 10,250 | Alpha',
        ];
        
        //Run Data Validation Rules
        $this->validate($request, $rules);
    }
}
