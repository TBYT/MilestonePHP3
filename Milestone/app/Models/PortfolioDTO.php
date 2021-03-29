<?php
namespace App\Models;

class PortfolioDTO implements \JsonSerializable
{
    private $errorCode;
    private $errorMessage;
    private $data;
    
    public function __construct($code, $message, $data)
    {
        $this->errorCode = $code;
        $this->errorMessage = $message;
        $this->data = $data;
    }
    
    public function jsonSerialize()
    {
        return get_object_vars($this);
    }
}
