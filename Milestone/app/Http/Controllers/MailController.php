<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Mail;
use App\Services\Business\BusinessService;
use App\Services\Data\Utility\ILoggerService;
use Carbon\Exceptions\Exception;

class MailController extends Controller
{
    //I made a new email for this project
    //Username: phpcst256@gmail.com
    //Password: adbsio3uiu9dnj2
    
    protected $logger;
    
    public function __construct(ILoggerService $logger)
    {
        $this->logger = $logger;
    }
    
    // Method to send basic email (html format)
    public function verificationEmail()
    {
        // Define who the email is going to
        $recipient = session('user')->getName();
        $email = session('user')->getEmail();
        $subject = "Email From Laravel Project";
        //Define the sender
        $sender = "Laravel CST-256";
        $sender_email = "heyHeyHey@gmail.com";
        
        $code = mt_rand(100000, 999999);
        session()->put('code', $code);
        
        //Define the array for the body of the email
        $data = array('name' => $recipient, 'body' => 'Hello. You just created an account wtih the E-Portfolio Networking Site. 
            This email is to verify your account. Enter this code in your site link to verify your account',
            'code' => $code
        );
        
        //Use the Mail class to send the email out
        //mail is the view we are using
        //$data is the array defining the body
        //You can pass the neccessary Variables with the use command
        try {
        Mail::send('emailresponse', $data, function($message) use ($recipient, $email, $subject,
            $sender, $sender_email)
        {
            $message->from($sender_email, $sender);
            $message->to($email, $recipient)->subject($subject);
        });
        }
        catch (Exception $e)
        {
            $this->logger->error("Something went wrong with sending an email: "+$e);
        }
        
        //Echo basic email send message
        return view('verify');
    }
    
    public function testCode()
    {
        //die(request('code') . ". session: " .  session('code'));
        if (request()->get('code') == session()->get('code'))
        {
            $service = new BusinessService();
            try {
            $id = $service->getUserId(session()->get('user'));
            $service->verifyUser($id);
            }
            catch (Exception $e)
            {
                $this->logger->error("Something went wrong with verifying a code for email: "+$e);
            }
            $data =  [
                'user' => session()->get('user'),
                'message' => 'Account Verified', 
            ];
            return view('account')->with($data);
        }
        else return $this->verificationEmail();
    }
}
