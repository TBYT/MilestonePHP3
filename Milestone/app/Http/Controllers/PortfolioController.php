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
        
        $portdata = $this->business->getPortfolioDetails($userid, $portfolioid); //
        
        
        $data = [ 'portfolio' => $portdata ];
        return view('portfolio')->with($data);
    }
    
    // Returns the port details page, with updated information.
    public function editPortfolio()
    {
        $this->business = new BusinessService();
        $this->user = new PortfolioModel();
        
        $userid = $this->business->getUserID(session()->get('user'));
        
        $portfolioid = $this->business->getPortfolioID($userid);
        
        /* Gets the data fields from the http post, and puts them in our model*/
        //$education = array();
        $education['institution'] = request()->get('institution');
        $education['startdate'] = request()->get('startdate');
        $education['enddate'] = request()->get('enddate');
        $education['gpa'] = request()->get('gpa');
        
        $this->user->addEducation($education);
        $this->user->addHistory(request()->get('history'));
        $this->user->addSkill(request()->get('skills'));
        
        // Update user
        $this->business->updatePortfolio($portfolioid, $this->user);
        
        //session()->put('portfolio', $this->user); //not used.
        
        $data = [ 'portfolio' => $this->user, ];
        return view('portfolio')->with($data);
    }
}