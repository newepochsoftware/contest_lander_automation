<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Colugo\API;

/**
 * Description of Client
 *
 * @author Christopher Mead
 */
class Client extends APIObject {
    private $id;
    private $name;
    private $clientHash;
    private $active;
    private $paused;
    private $credits;
    private $costPerLead;
    private $weight;
    private $dailyLimits;
    private $maximumLeadAge;
    private $minimumLeadAge;
    
    /**
     *
     * @var \Colugo\API\ClientContactInfo
     */
    private $contactInfo;
    
    public function __construct() {
    }
    
    public function getId() {
        return $this->id;
    }
    
    public function setId($id) {
        $this->id = $id;
        return $this;
    }
    
    public function getName() {
        return $this->name;
    }
    
    public function setName($name) {
        $this->name = $name;
        return $this;
    }
    
    public function getClientHash() {
        return $this->clientHash;
    }
    
    public function setClientHash($clientHash) {
        $this->clientHash = $clientHash;
        return $this;
    }
    
    public function getActive() {
        return $this->active;
    }
    
    public function isActive() {
        return $this->getActive();
    }
    
    public function setActive($active) {
        $this->active = $active;
        return $this;
    }
    
    public function getPaused() {
        return $this->paused;
    }
    
    public function isPaused() {
        return $this->getPaused();
    }
    
    public function setPaused($paused) {
        $this->paused = $paused;
        return $this;
    }
    
    public function getCredits() {
        return $this->credits;
    }
    
    public function setCredits($credits) {
        $this->credits = $credits;
        return $this;
    }
    
    public function getCostPerLead() {
        return $this->costPerLead;
    }
    
    public function setCostPerLead($costPerLead) {
        $this->costPerLead = $costPerLead;
        return $this;
    }
    
    public function getWeight() {
        return $this->weight;
    }
    
    public function setWeight($weight) {
        $this->weight = $weight;
        return $this;
    }
    
    public function getDailyLimits() {
        return $this->dailyLimits;
    }
    
    public function setDailyLimits($dailyLimits) {
        $this->dailyLimits = $dailyLimits;
        return $this;
    }
    
    public function getMaximumLeadAge() {
        return $this->maximumLeadAge;
    }
    
    public function setMaximumLeadAge($maximumLeadAge) {
        $this->maximumLeadAge = $maximumLeadAge;
        return $this;
    }
    
    public function getMinimumLeadAge() {
        return $this->minimumLeadAge;
    }
    
    public function setMinimumLeadAge($minimumLeadAge) {
        $this->minimumLeadAge = $minimumLeadAge;
        return $this;
    }
    
    /**
     * 
     * @return \Colugo\API\ClientContactInfo
     */
    public function getContactInfo() {
        return $this->contactInfo;
    }
    
    /**
     * 
     * @param \Colugo\API\ClientContactInfo $contactInfo
     */
    public function setContactInfo(\Colugo\API\ClientContactInfo $contactInfo) {
        $this->contactInfo = $contactInfo;
    }
    
    public function __getUrl() {
        if (null == $this->getId()) {
            throw new \Exception("NullLeadIdException");
        }
        return sprintf("/clients/%d", $this->getId());
    }

    public function __postUrl() {
        return "/clients";
    }

    public function __putUrl() {
        if (null == $this->getId()) {
            throw new \Exception("NullLeadIdException");
        }
        return sprintf("/clients/%d", $this->getId());
    }

}
