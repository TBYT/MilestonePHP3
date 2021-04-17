<?php

/**
 * Author: Brian Basinger
 * CST-256
 * 2.23.21
 */

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use App\Models\PortfolioModel;
use App\Services\Business\BusinessService;
use App\Services\Data\Utility\ILoggerService;
use Carbon\Exceptions\Exception;
//use App\Services\Business\PrivilegeCheck;

class PortfolioController extends BaseController
{
        use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    private $user;
    private $business;

    protected $logger;
    
    public function __construct(ILoggerService $logger)
    {
        $this->logger = $logger;
    }
    
    //Function queries the database for the 
    public function search()
    {
        //can only search by name
        $this->business = new BusinessService();
        $this->user = new PortfolioModel();
        
        try {
        //Return type: array($userid => name)
        $users = $this->business->searchByName(request()->get('pattern')); 
        }
        catch (Exception $e)
        {
            $this->logger->error("Something went wrong with searching a portfolio: "+$e);
        }
        //Empty Array
        $portfolios = array();
        
        try {
        //For each user with the specified name
        foreach ($users as $id => $user)
        {
            //If the user has a portfolio, save it
            if ($portID = $this->business->getPortfolioID($id))
            {
                $portfolios[$portID] = [$user->getName(), $this->business->getPortfolioDetails($portID)];
            }
        }
        }
        catch (Exception $e)
        {
            $this->logger->error("Something went wrong with getting search results for portfolios: "+$e);
        }
        
        //Default is success
        $message = "Search Results";
        
        //If failure
        if (count($portfolios) == 0)
        {
            $message = "No Results Found, Please Try Again";
        }
        
        //Return data
        $data = [
            'portfolios' => $portfolios,
            'message' => $message,
        ];
        
        return view('searchportfolios')->with($data);
    }
    
    // Returns the account details page
    public function viewPortfolio()
    {
        //$this->pc = new PrivilegeCheck();
        $this->business = new BusinessService();
        
        // Gets the session user, might be depreciated??
        if ($this->user = session()->get('user') == null)
        {
            return view("welcome");
        }
        else $this->user = session()->get('user');
        
        $userid = $this->business->getUserID(session()->get('user'));
        
        try {
        $portfolioid = $this->business->getPortfolioID($userid);
        }
        catch (Exception $e)
        {
            $this->logger->error("Something went wrong with getting portfolio id in viewPortfolio method.: "+$e);
        }

        try {
        if ($portfolioid == 0)
        {
            $this->business->createPortfolio($userid);
        }
        $portdata = $this->business->getPortfolioDetails($portfolioid);
        catch (Exception $e)
        {
            $this->logger->error("Something went wrong with creating a new portfolio or getting portfolio details: "+$e);
        }
        
        $data = [ 
            'portfolio' => $portdata ,
            'portfolioID' => $portfolioid,
        ];
        return view('portfolio')->with($data);
    }
    
    // Returns the port details page, with updated information.
    public function editPortfolio()
    {
        $this->business = new BusinessService();
        $this->user = new PortfolioModel();
        
        $portfolioID = request()->get('portfolioID'); 
        
        try {
        //Get Portfolio ID from the user
        //For each 100 + index set, add an education
        $index = 100;
        while(request()->get('' . $index . ',institution') != null)
        {
            $education = [
                'institution' => request()->get('' . $index . ',institution'),
                'startdate' => request()->get('' . $index . ',startdate'),
                'enddate' => request()->get('' . $index . ',enddate'),
                'gpa' => request()->get('' . $index++ . ',gpa'),
            ];
//             $rules = [
//                 '' . $index . ',institution' => 'Required|Alpha_Dash',
//                 '' . $index . ',startdate' => 'Required|Date',
//                 '' . $index . ',enddate' => 'Required|Date',
//                 '' . $index . ',gpa' => 'Required|Numeric|Between:0,5',
//             ];
            
//            $this->validate(request(), $rules);
            
            $this->user->addEducation($education);
        }
        
        //For each 200 + index set, add a skill
        $index = 200;
        //die ("Request 200: " . request()->get('' . $index));
        while (request()->get('' . $index) != null)
        {
//             $rules = [
//                 '' . $index => '', 'Required|Alpha_Dash',
//             ];
            
//             $this->validate(request(), $rules);
            
            $this->user->addSkill(request()->get('' . $index++));
            
        }
        
        //For each 300 + index set, add a job history
        $index = 300;
        while (request()->get('' . $index) != null)
        {
//             $rules = [
//                 '' . $index => '', 'Required|Alpha_Dash',
//             ];
            
//            $this->validate(request(), $rules);
            
            $this->user->addHistory(request()->get('' . $index++));
        }
        
        $message = 'Portfolio Updated!';
        
        //Take the portfolio id
        //Call the business service method with the portfolio id and the portfolio details
        if (!$this->business->updatePortfolio($portfolioID, $this->user))
        {
            $message = "Portfolio Update Failed";
            $this->user = $this->business->getPortfolioDetails($portfolioID);
        }

        }
        catch (Exception $e)
        {
            $this->logger->error("Something went wrong with updating user portfolio: "+$e);
        }
        
        $data = [
            'portfolio' => $this->user,
            'portfolioID' => $portfolioID,
            'message' => $message,
        ];
        
        //die("Returning view. data var: " . print_r($data));
        
        return view('portfolio')->with($data);
    }
    
    //Function to add a history
    //TODO: this function is almost identical to addEducation and addSkill, maybe combine?
    public function addHistory()
    {
        //$this->pc = new PrivilegeCheck();
        //Initialize business layer and portfolio instance
        $this->business = new BusinessService();
        $this->user = new PortfolioModel();
        
        //Get portfolio id from request
        $portfolioID = request()->get('portfolioID');
        
        try {
        //Add a blank history to the portfolio id
        $this->business->addHistory($portfolioID);
        
        //Get the updated portfolio
        $portfolio = $this->business->getPortfolioDetails($portfolioID);
        }
        catch (Exception $e)
        {
            $this->logger->error("Something went wrong with adding history in portfolio: "+$e);
        }
        
        //Pass back portfolio info
        $data = [
            'portfolio' => $portfolio,
            'portfolioID' => $portfolioID,
        ];
        
        //Return to view page
        return view('portfolio')->with($data);
    }
    
    //Function to add education, see addHistory()
    public function addEducation()
    {
        //$this->pc = new PrivilegeCheck();
        //Initialize business layer and portfolio instance
        $this->business = new BusinessService();
        $this->user = new PortfolioModel();
        
        //Get portfolio id from request
        $portfolioID = request()->get('portfolioID');
        
        try {
        //Add a blank education to the portfolio id
        $this->business->addEducation($portfolioID);
        //Get the updated portfolio
        $portfolio = $this->business->getPortfolioDetails($portfolioID);
        }
        catch (Exception $e)
        {
            $this->logger->error("Something went wrong with adding education in portfolio: "+$e);
        }
        
        //Pass back portfolio info
        $data = [
            'portfolio' => $portfolio,
            'portfolioID' => $portfolioID,
        ];
        return view('portfolio')->with($data);
    }
    
    public function addSkill()
    {
        //$this->pc = new PrivilegeCheck();
        //Initialize business layer and portfolio instance
        $this->business = new BusinessService();
        $this->user = new PortfolioModel();
        
        //Get portfolio id from request
        $portfolioID = request()->get('portfolioID');
        
        try {
        //Add a blank skill to the portfolio id
        $this->business->addSkill($portfolioID);
        //Get the updated portfolio
        $portfolio = $this->business->getPortfolioDetails($portfolioID);
        }
        catch (Exception $e)
        {
            $this->logger->error("Something went wrong with adding skills in portfolio: "+$e);
        }
        
        //Pass back portfolio info
        $data = [
            'portfolio' => $portfolio,
            'portfolioID' => $portfolioID,
        ];
        return view('portfolio')->with($data);
    }
}
