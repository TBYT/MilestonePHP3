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

class PortfolioAPIController extends BaseController
{
    private $business;
    
    public function show($id)
    {
        //
        $business = new BusinessService();
        
        $portfolio = $business->getPortfolioDetails($id);
        
        $errorCode = 402;
        $errorMessage = 'Could Not Retrieve The User From The Database';
        
        if ($portfolio != false)
        {
            $errorCode = 200;
            $errorMessage = '';
        }
        
        $dto = new JobDTO($errorCode, $errorMessage, print_r($portfolio));
        
        return $dto->jsonSerialize();
    }
}
