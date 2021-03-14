<?php
namespace App\Services\Business;

use Illuminate\Routing\Router;

class PrivilegeCheck
{
    //depreciated
    function SecurityisAdmin($in)
    {
        Router::class($in);
         if (session()->get('isAdmin') == false)
        {
            return "welcome";
        }
        else
            return $in;
    }
    
    
    function SecurityisLoggedIn($in)
    {
        if (session()->get('user') == false)
        {
            return "welcome";
        }
        else
            return $in;
    }
    
}