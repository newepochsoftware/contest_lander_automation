<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Colugo\API;

/**
 * Description of Lead
 *
 * @author Christopher Mead
 */
class Lead extends APIObject {

    private $id;
    private $userId;
    private $schemaId;
    private $leadTime;
    private $leadDate;
    private $leadStatus;
    private $leadSource;
    private $leadIpAddress;
    private $client;
    private $clientLeadLog;
    private $fields;

    public function __construct() {
        $this->fields = new \stdClass();
    }

    public function getId() {
        return $this->id;
    }
    
    public function __load__from__object($object) {
        parent::__load__from__object($object);
        $this->fields = $object;
    }
    
    public function __get($name) {
        if (isset($this->fields->$name)) {
            return $this->fields->$name;
        }
        return null;
    }

    /**
     * sets the id associated with this lead
     * @param int $id
     * @return \Colugo\API\Lead
     */
    public function setId($id) {
        $this->id = $id;
        return $this;
    }
    
    public function getClient() {
        return $this->client;
    }
    
    public function setClient($client) {
        $this->client = $client;
    }
    
    public function getClientLeadLog() {
        return $this->clientLeadLog;
    }
    
    public function setClientLeadLog($clientLeadLog) {
        $this->clientLeadLog = $clientLeadLog;
    }

    public function getUserId() {
        return $this->userId;
    }

    public function setUserId($userId) {
        $this->userId = $userId;
        return $this;
    }

    public function getSchemaId() {
        return $this->schemaId;
    }

    public function setSchemaId($schemaId) {
        $this->schemaId = $schemaId;
        return $this;
    }

    /**
     * 
     * @return \DateTime
     */
    public function getLeadTime() {
        return $this->leadTime;
    }

    /**
     * 
     * @param \DateTime $leadTime
     * @return \Colugo\API\Lead
     */
    public function setLeadTime($leadTime) {
        $this->leadTime = $leadTime;
        return $this;
    }

    public function getLeadDate() {
        return $this->leadDate;
    }

    public function setLeadDate($leadDate) {
        $this->leadDate = $leadDate;
        return $this;
    }

    public function getLeadStatus() {
        return $this->leadStatus;
    }

    /**
     * 
     * @param type $leadStatus
     * @return \Colugo\API\Lead
     */
    public function setLeadStatus($leadStatus) {
        $this->leadStatus = $leadStatus;
        return $this;
    }

    public function getLeadSource() {
        return $this->leadSource;
    }

    public function setLeadSource($leadSource) {
        $this->leadSource = $leadSource;
        return $this;
    }

    public function getLeadIpAddress() {
        return $this->leadIpAddress;
    }

    public function setLeadIpAddress($leadIpAddress) {
        $this->leadIpAddress = $leadIpAddress;
        return $this;
    }

    public function getFields() {
        return $this->fields;
    }

    /**
     * 
     * @param type $fields
     * @return \Colugo\API\Lead
     */
    public function setFields($fields) {
        if (is_array($fields)) {
            $this->fields = (object) $fields;
        } elseif ($fields instanceof \stdClass) {
            $this->fields = $fields;
        } else {
            throw new \Exception("InvalidFieldsType, must be array or stdClass object");
        }
        return $this;
    }

    public function __getUrl() {
        if (null == $this->getId()) {
            throw new \Exception("NullLeadIdException");
        }
        return sprintf("/leads/%d", $this->getId());
    }

    public function __postUrl() {
        return "/leads";
    }
    
    public function __putUrl() {
        if (null == $this->getId()) {
            throw new \Exception("NullLeadIdException");
        }
        return sprintf("/leads/%d", $this->getId());
    }

}
