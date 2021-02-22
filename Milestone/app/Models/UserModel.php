<?php

/**
 * Author: Thomas Biegel
 * CST-256
 * 2.8.21
 */

namespace App\Models;

class UserModel
{
    private $password;
    private $email;
    private $bio;
    private $field;
    private $picture;
    private $name;
    private $webLink;
    private $city;
    private $state;
    private $isSuspended;
    
    //Constructor
    public function __construct()
    {
          
    }
    
    //non-default constructor
    public function createFullUser($password, $email, $bio, $field, $picture, $name, $webLink, $city, $state)
    {
        $this->password = $password;
        $this->email = $email;
        $this->bio = $bio;
        $this->picture = $picture;
        $this->name = $name;
        $this->webLink = $webLink;
        $this->city = $city;
        $this->state = $state;
    }
    
    public function isSuspended()
    {
        return $this->isSuspended;
    }
    
    public function setIsSuspended(bool $suspend)
    {
        $this->isSuspended = $suspend;
    }
    
    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @return mixed
     */
    public function getBio()
    {
        return $this->bio;
    }

    /**
     * @return mixed
     */
    public function getField()
    {
        return $this->field;
    }

    /**
     * @return mixed
     */
    public function getPicture()
    {
        return $this->picture;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return mixed
     */
    public function getWebLink()
    {
        return $this->webLink;
    }

    /**
     * @return mixed
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * @return mixed
     */
    public function getState()
    {
        return $this->state;
    }

    /**
     * @param mixed $password
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }

    /**
     * @param mixed $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @param mixed $bio
     */
    public function setBio($bio)
    {
        $this->bio = $bio;
    }

    /**
     * @param mixed $field
     */
    public function setField($field)
    {
        $this->field = $field;
    }

    /**
     * @param mixed $picture
     */
    public function setPicture($picture)
    {
        $this->picture = $picture;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @param mixed $webLink
     */
    public function setWebLink($webLink)
    {
        $this->webLink = $webLink;
    }

    /**
     * @param mixed $city
     */
    public function setCity($city)
    {
        $this->city = $city;
    }

    /**
     * @param mixed $state
     */
    public function setState($state)
    {
        $this->state = $state;
    }
    
    /**
     * Getter method -> password
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }
}