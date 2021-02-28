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

class PortfolioController extends BaseController
{
        use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    private $user;
    private $business;

    
    //Function queries the database for the 
    public function search()
    {
        //can only search by name
        $this->business = new BusinessService();
        $this->user = new PortfolioModel();
        
        //Return type: array($userid => name)
        $users = $this->business->searchByName(request()->get('pattern')); 
        
        //Empty Array
        $portfolios = array();
        
        //For each user with the specified name
        foreach ($users as $id => $user)
        {
            //If the user has a portfolio, save it
            if ($portID = $this->business->getPortfolioID($id))
            {
                $portfolios[$portID] = [$user->getName(), $this->business->getPortfolioDetails($id, $portID)];
            }
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
        $this->business = new BusinessService();
        
        // Gets the session user
        $this->user = session()->get('user');
        
        $userid = $this->business->getUserID(session()->get('user'));
        
        $portfolioid = $this->business->getPortfolioID($userid);
        
        if ($portfolioid == 0)
        {
            $this->business->createPortfolio($userid);
        }
        
        else 
        {
            $portdata = $this->business->getPortfolioDetails($userid, $portfolioid);
        }
        
        $data = [ 
            'portfolio' => $portdata ,
            'portfolioID' => $portfolioid,
        ];
        return view('portfolio')->with($data);
    
            //Test data
//         $portdata = new PortfolioModel();
        
//         $portdata->addSkill("TestSkill");
//         $portdata->addSkill("TestSkill1");
//         $portdata->addSkill("TestSkill2");
//         $portdata->addSkill("TestSkill3");
        
//         $portdata->addHistory("TestHistory");
        
//         $education = [
//             'institution' => 'HRA',
//             'startdate' => '2/12/52',
//             'enddate' => '32/53/213',
//             'gpa' => '4.2'
//         ];
        
//         $portdata->addEducation($education);
    }
    
    // Returns the port details page, with updated information.
    public function editPortfolio()
    {
        $this->business = new BusinessService();
        $this->user = new PortfolioModel();
        
        $portfolioID = request()->get('portfolioID'); 
        
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
            $this->user = $this->business->getPortfolioDetails(0, $portfolioID);
        }
        
        $data = [
            'portfolio' => $this->user,
            'portfolioID' => $portfolioID,
            'message' => $message,
        ];
        
        //die("Returning view. data var: " . print_r($data));
        
        return view('portfolio')->with($data);
    }
    
    public function addHistory()
    {
        $this->business = new BusinessService();
        $this->user = new PortfolioModel();
        
        $portfolioID = request()->get('portfolioID');
        
        $this->business->addHistory($portfolioID);
        $portfolio = $this->business->getPortfolioDetails(0, $portfolioID);
        
        $data = [
            'portfolio' => $portfolio,
            'portfolioID' => $portfolioID,
        ];
        
        return view('portfolio')->with($data);
    }
    
    public function addEducation()
    {
        $this->business = new BusinessService();
        $this->user = new PortfolioModel();
        
        $portfolioID = request()->get('portfolioID');
        
        $this->business->addEducation($portfolioID);
        $portfolio = $this->business->getPortfolioDetails(0, $portfolioID);
        
        $data = [
            'portfolio' => $portfolio,
            'portfolioID' => $portfolioID,
        ];
        
        return view('portfolio')->with($data);
    }
    
    public function addSkill()
    {
        $this->business = new BusinessService();
        $this->user = new PortfolioModel();
        
        $portfolioID = request()->get('portfolioID');
        
        $this->business->addSkill($portfolioID);
        $portfolio = $this->business->getPortfolioDetails(0, $portfolioID);
        
        $data = [
            'portfolio' => $portfolio,
            'portfolioID' => $portfolioID,
        ];
        
        return view('portfolio')->with($data);
    }
}