<?php
namespace App\Services\Data;

use App\Models\PortfolioModel;

class PortfolioDataService
{
    private $conn;
    
    public function __construct($conn)
    {
        $this->conn = $conn;
    }
    
    /**
     * Function to add an empty portfolio to the database
     * @param int $userID the id of the user whose portfolio is being added
     * @return bool whether the entry was added successfuly
     */
    public function addPortfolio(int $userID)
    {
        //Create sql
        
        //Query SQL
        
        //Return true if the data was added
        return true;
    }
    
    /**
     * 
     * @param string $education the education to be added. NB: This will need to be changed to an education model if you are using one
     * @param int $portfolioID the id of the portfolio to which an entry is being added
     * @return boolean whether the entry was added successfuly
     */
    public function addEducation(string $education, int $portfolioID)
    {
        //Create sql
        
        //Query SQL
        
        //Return true if the data was added
        return true;
    }
    
    /**
     * 
     * @param string $experience the data to be added
     * @param int $portfolioID the id of the portfolio to which an entry is being added
     * @return boolean whether the entry was added successfuly
     */
    public function addExperience(string $experience, int $portfolioID)
    {
        //Create sql
        
        //Query SQL
        
        //Return true if the data was added
        return true;
    }
    
    /**
     * Adds a history
     * @param string $history the data to be added
     * @param int $portfolioID the id of the portfolio to which an entry is being added
     * @return boolean whether the entry was added successfuly
     */
    public function addHistory(string $history, int $portfolioID)
    {
        //Create sql
        
        //Query SQL
        
        //Return true if the data was added
        return true;
    }
}

