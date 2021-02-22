<?php
namespace App\Models;

class PortfolioModel
{
    private $education;
    private $skills;
    private $history;
    
    public function __construct()
    {
        $this->education = array();
        $this->skills = array();
        $this->history = array();
    }
    /**
     * @return mixed
     */
    public function getEducation()
    {
        return $this->education;
    }

    /**
     * @return mixed
     */
    public function getSkills()
    {
        return $this->skills;
    }

    /**
     * @return mixed
     */
    public function getHistory()
    {
        return $this->history;
    }

    /**
     * @param mixed $experience
     */
    public function setExperience($experience)
    {
        $this->experience = $experience;
    }

    /**
     * @param mixed $skills
     */
    public function setSkills($skills)
    {
        $this->skills = $skills;
    }

    /**
     * @param mixed $history
     */
    public function setHistory($history)
    {
        $this->history = $history;
    }
    
    public function addHistory(string $item)
    {
        array_push($this->history, $item);
    }
    
    public function addSkill(string $item)
    {
        array_push($this->skills, $item);
    }
    
    public function addEducation(string $item)
    {
        array_push($this->education, $item);
    }
}

