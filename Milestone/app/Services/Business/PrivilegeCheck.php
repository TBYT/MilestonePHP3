<?php
namespace App\Services\Business;

/**
 * Author: Brian Basinger
 * CST-256
 * 2.28.21
 */
class PrivilegeCheck
{
    function SecurityisAdmin($in)
    {
        //Router::class($in);
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