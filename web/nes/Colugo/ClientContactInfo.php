<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Colugo\API;

/**
 * Description of ClientContactInfo
 *
 * @author Christopher Mead
 */
class ClientContactInfo extends APIObject {

    private $id;
    private $contactName;
    private $company;
    private $address1;
    private $address2;
    private $city;
    private $state;
    private $country;
    private $zip;
    private $zipPlusFour;
    private $phone1;
    private $phone2;
    private $fax1;
    private $fax2;
    private $email1;
    private $email2;

    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
        return $this;
    }

    public function getContactName() {
        return $this->contactName;
    }

    public function setContactName($contactName) {
        $this->contactName = $contactName;
        return $this;
    }
    
    public function getCompany() {
        return $this->company;
    }
    
    public function setCompany($company) {
        $this->company = $company;
    }

    public function getAddress1() {
        return $this->address1;
    }

    public function setAddress1($address1) {
        $this->address1 = $address1;
        return $this;
    }

    public function getAddress2() {
        return $this->address2;
    }

    public function setAddress2($address2) {
        $this->address2 = $address2;
        return $this;
    }

    public function getCity() {
        return $this->city;
    }

    public function setCity($city) {
        $this->city = $city;
        return $this;
    }

    public function getState() {
        return $this->state;
    }

    public function setState($state) {
        $this->state = $state;
        return $this;
    }

    public function getCountry() {
        return $this->country;
    }

    public function setCountry($country) {
        $this->country = $country;
        return $this;
    }

    public function getZip() {
        return $this->zip;
    }

    public function setZip($zip) {
        $this->zip = $zip;
        return $this;
    }

    public function getZipPlusFour() {
        return $this->zipPlusFour;
    }

    public function setZipPlusFour($zipPlusFour) {
        $this->zipPlusFour = $zipPlusFour;
        return $this;
    }

    public function getPhone1() {
        return $this->phone1;
    }

    public function setPhone1($phone1) {
        $this->phone1 = $phone1;
        return $this;
    }

    public function getPhone2() {
        return $this->phone2;
    }

    public function setPhone2($phone2) {
        $this->phone2 = $phone2;
        return $this;
    }

    public function getFax1() {
        return $this->fax1;
    }

    public function setFax1($fax1) {
        $this->fax1 = $fax1;
        return $this;
    }

    public function getFax2() {
        return $this->fax2;
    }

    public function setFax2($fax2) {
        $this->fax2 = $fax2;
        return $this;
    }

    public function getEmail1() {
        return $this->email1;
    }

    public function setEmail1($email1) {
        $this->email1 = $email1;
        return $this;
    }

    public function getEmail2() {
        return $this->email2;
    }

    public function setEmail2($email2) {
        $this->email2 = $email2;
        return $this;
    }

    public function __getUrl() {
        return sprintf("/clients/contact/info/%d", $this->getId());
    }

    public function __postUrl() {
        return sprintf("/clients/contact/info/%d", $this->getId());
    }

    public function __putUrl() {
        return sprintf("/clients/contact/info/%d", $this->getId());
    }

//put your code here
}
