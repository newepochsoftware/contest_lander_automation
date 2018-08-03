<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Colugo\API;

/**
 * Description of Zip
 *
 * @author Christopher Mead
 */
class Zip extends APIObject {
    private $id;
    
    private $zipCode;
    
    private $city;
    
    private $state;
    
    private $county;
    
    private $areaCode;
    
    private $cityType;
    
    private $cityAliasAbbreviation;
    
    private $cityAliasName;
    
    private $latitude;
    
    private $longitude;
    
    private $timeZone;
    
    private $cityMixedCase;

    
    public function __construct() {
    }
    
    /**
     * 
     * @return string
     */
    public function getId() {
        return $this->id;
    }
    
    /**
     * 
     * @param type $id
     * @return \Colugo\API\Zip
     */
    public function setId($id) {
        $this->id = $id;
        return $this;
    }
    
    /**
     * 
     * @param type $city
     * @return \Colugo\API\Zip
     */
    public function setCity($city) {
        $this->city = $city;
        return $this;
    }
    
    public function getCity() {
        return $this->city;
    }
    
    /**
     * 
     * @param type $state
     * @return \Colugo\API\Zip
     */
    public function setState($state) {
        $this->state = $state;
        return $this;
    }
    
    public function getState() {
        return $this->state;
    }
    
    /**
     * 
     * @param type $county
     * @return \Colugo\API\Zip
     */
    public function setCounty($county) {
        $this->county = $county;
        return $this;
    }
    
    public function getCounty() {
        return $this->county;
    }
    
    /**
     * 
     * @param type $areaCode
     * @return \Colugo\API\Zip
     */
    public function setAreaCode($areaCode) {
        $this->areaCode = $areaCode;
        return $this;
    }
    
    public function getAreaCode() {
        return $this->areaCode;
    }
    
    /**
     * 
     * @param string $cityType
     * @return \Colugo\API\Zip
     */
    public function setCityType($cityType) {
        $this->cityType = $cityType;
        return $this;
    }
    
    public function getCityType() {
        return $this->cityType;
    }
    
    /**
     * 
     * @param type $cityAliasAbbreviation
     * @return \Colugo\API\Zip
     */
    public function setCityAliasAbbreviation($cityAliasAbbreviation) {
        $this->cityAliasAbbreviation = $cityAliasAbbreviation;
        return $this;
    }
    
    public function getCityAliasAbbreviation() {
        return $this->cityAliasAbbreviation;
    }
    
    /**
     * 
     * @param type $cityAliasName
     * @return \Colugo\API\Zip
     */
    public function setCityAliasName($cityAliasName) {
        $this->cityAliasName = $cityAliasName;
        return $this;
    }
    
    public function getCityAliasName() {
        return $this->cityAliasName;
    }
    
    /**
     * 
     * @param type $latitude
     * @return \Colugo\API\Zip
     */
    public function setLatitude($latitude) {
        $this->latitude = $latitude;
        return $this;
    }
    
    public function getLatitude() {
        return $this->latitude;
    }
    
    /**
     * 
     * @param type $longitude
     * @return \Colugo\API\Zip
     */
    public function setLongitude($longitude) {
        $this->longitude = $longitude;
        return $this;
    }
    
    public function getLongitude() {
        return $this->longitude;
    }
    
    /**
     * 
     * @param type $timeZone
     * @return \Colugo\API\Zip
     */
    public function setTimeZone($timeZone) {
        $this->timeZone = $timeZone;
        return $this;
    }
    
    public function getTimeZone() {
        return $this->timeZone;
    }
    
    /**
     * 
     * @param type $cityMixedCase
     * @return \Colugo\API\Zip
     */
    public function setCityMixedCase($cityMixedCase) {
        $this->cityMixedCase = $cityMixedCase;
        return $this;
    }
    
    /**
     * 
     * @return string
     */
    public function getCityMixedCase() {
        return $this->cityMixedCase;
    }
    
    /**
     * Fetches the zip object's zip code
     * @return string
     */
    public function getZipCode() {
        return $this->zipCode;
    }
    
    /**
     * Sets the Zip object's zipcode
     * @param string $zipCode
     * @return \Colugo\API\Zip
     */
    public function setZipCode($zipCode) {
        $this->zipCode = $zipCode;
        $this->id = $zipCode;
        return $this;
    }

    public function __getUrl() {
        if (null == $this->getZipCode()) {
            throw new Exception("NullZipCodeException");
        }
        return sprintf("/zip/%s", $this->getZipCode());
    }

    /**
     * Adding zip codes isn't allowed by the system
     * @throws type
     */
    public function __postUrl() {
        throw \Exception("Method Not Implemented");
    }
    
    /**
     * Adding zip codes isn't allowed by the system
     * @throws type
     */
    public function __putUrl() {
        throw \Exception("Method Not Implemented");
    }

}
