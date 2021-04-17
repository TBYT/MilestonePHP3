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
        
        //$this->validateForm(request());
        
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
        try
        {
        $jobs = $this->businessService->getAllJobs();
        $appliedjobs = $this->showAllApplied();
        
        }
        catch (Exception $e)
        {
            $this->logger->error("Something went wrong with showing all jobs: "+$e);
        }
        
        $data = [
            'appliedjobs' => $appliedjobs,
            'jobs' => $jobs,
        ];
        //die (print_r($data));
        //Feels... Good. Man
        //return view('admin\alljobs')->with($data);
        return view('alljobs')->with($data);
    }
    
    //utility method to get all applied jobs whenever we return to the alljobs page.
    public function showAllApplied()
    {
        $userID = $this->businessService->getUserID(session()->get('user'));
        $appliedjobsids = $this->businessService->getAppliedJobs($userID);
        
        $appliedjobs = array();
        foreach ($appliedjobsids as $id)
        {
            $appliedjobs[$id] = $this->businessService->getJob($id);
        }
        return $appliedjobs;
    }
    
    //Function to delete a job
    public function delete()
    {
        //Initialize business service and delete job
        $this->businessService = new BusinessService();
        try 
        {
            if ($this->businessService->deleteJob(request()->get('id')))
            {
                $message = 'Job Deleted!';
            }
            else
            {
                $message = 'Something went wrong with deleting a job';
            }
        
        //Rerun the get all jobs page wtih updated list of jobs
        $jobs = $this->businessService->getAllJobs();
        
        $appliedjobs = $this->showAllApplied();
        }
        catch (Exception $e)
        {
            $this->logger->error("Something went wrong with deleting a job: "+$e);
        }
        
        $data = [
            'jobs' => $jobs,
            'message' => $message,
            'appliedjobs' => $appliedjobs,
        ];
        
        return view('alljobs')->with($data);
    }
    
    
    //Function to edit a job's details
    public function doEdit()
    {
        //Initialize business layer and job 
        $this->businessService = new BusinessService();
        
        $this->job = new JobModel();
        
        //Validate 
        //$this->validateForm(request());
        
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
        $appliedjobs = $this->showAllApplied();
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
            'appliedjobs' => $appliedjobs,
            'jobs' => $jobs,
            'message' => $message
        ];
        
        return view('alljobs')->with($data);
    }
    
    //Function to edit a job
    public function edit()
    {
        //Initialize the business layer and job
        $this->businessService = new BusinessService();
        try 
        {
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
        
        try 
        {
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
            //Get the current job that is being displayed by its id
            $this->job = $this->businessService->getJob(request()->get('id'));
            
            //If the user has applied for the job, don't show the apply button
            //First find the user id from the user saved in session var
            $user_id = $this->businessService->getUserID(session()->get('user'));
            //Next get a list of all applied jobs for that user (only need ids, otherwise would call the 
            //showAllApplications() in this class)
            $appliedJobs = $this->businessService->getAppliedJobs($user_id);
            //Test to make sure that the list of applications was called
            //die(print_r($appliedJobs));'
            //die(request()->get('id') . '\t');
            //Default applied status is false, will display button
            $isApplied = false;
            //Finally, search the list of applied jobs for the id of the current job
            //TODO: maybe give status update in the view('viewjob.blade.php')?
            foreach ($appliedJobs as $id)
            {
                if ($id == request()->get('id'))
                {
                    $isApplied = true;
                    break;
                }
            }
        }
        catch (Exception $e)
        {
            $this->logger->error("Something went wrong with viewing a job: "+$e);
        }
        //Should use flash here, but I am lazy and don't have a lot of practice with it
        $data = [
            'job' => $this->job,
            'id' => request()->get('id'),
            'isApplied' => $isApplied
        ];
        
        return view('viewjob')->with($data);
    }
    
    private function validateForm(Request $request)
    {
        $rules = [
            'title' => 'Required | Between: 6,30 | Alpha_Dash',
            'company' => 'Required | Between: 3, 30 | Alpha_Num',
            'salary' => 'Required | Alpha_Num | Between: 4, 7',
            'field' => 'Required | Between: 3,30 | Alpha_Dash',
            'skills' => 'Required | Between: 3,30 | Alpha_Dash',
            'experience' => 'Required | Between: 2,30| Alpha_Num',
            'location' => 'Required | Between: 5,50 | Alpha_Dash',
            'description' => 'Required | Between: 10,250 | Alpha_Num',
        ];
        
        //Run Data Validation Rules
        $this->validate($request, $rules);
    }
    
    public function apply()
    {
        $this->businessService = new BusinessService();
        $jobID = request()->get('id');
        $userID = $this->businessService->getUserID(session()->get('user'));
        
        //apply to the job
        if ($this->businessService->jobApply($userID, $jobID))
        {
            //die("success");
        }
        
        //Return all jobs view
        return $this->showAll();
    }
}
