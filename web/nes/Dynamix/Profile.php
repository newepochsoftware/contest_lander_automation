<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Dynamix\API;

/**
 * Description of Profile
 *
 * @author Christopher Mead
 */
class Profile implements \JsonSerializable {

    /**
     * The profile's identifier
     * @var string
     */
    private $name;

    /**
     * The xid values for this profile
     * @var string[]
     */
    private $fields = [];

    /**
     * Default profile xid values
     * @var string[]
     */
    private $defaultFields = [];

    public function __construct($name = null, $fields = null) {
        $this->name = $name;
        if (null != $fields && is_array($fields)) {
            $this->fields = $fields;
        }
    }

    public function getName() {
        return $this->name;
    }

    /**
     * 
     * @param type $name
     * @return \Dynamix\API\Profile
     */
    public function setName($name) {
        $this->name = $name;
        return $this;
    }

    /**
     * 
     * @return string[]
     */
    public function getFields() {
        return $this->fields;
    }

    /**
     * 
     * @param type $fields
     * @return \Dynamix\API\Profile
     */
    public function setFields($fields) {
        if (null != $fields && is_array($fields)) {
            $this->fields = $fields;
        }
        return $this;
    }

    /**
     * 
     * @return string
     */
    public function getDefaultFields() {
        return $this->defaultFields;
    }

    /**
     * 
     * @param type $defaultFields
     * @return \Dynamix\API\Profile
     */
    public function setDefaultFields($defaultFields) {
        if (null != $defaultFields && is_array($defaultFields)) {
            $this->defaultFields = $defaultFields;
        }
        return $this;
    }

    /**
     * Fetches a XID from the fields array, using a default
     * if the XID is either non-existence or an empty string
     * @param string $xid
     * @param string $default
     * @return string
     */
    public function getField($xid, $default = "") {
        if (isset($this->fields[$xid]) && null != $this->fields[$xid] && $this->fields[$xid] != "") {
            return $this->fields[$xid];
        }
        if (isset($this->defaultFields[$xid]) && null != $this->defaultFields[$xid] && $this->defaultFields[$xid] != "") {
            return $this->defaultFields[$xid];
        }
        return $default;
    }
    
    /**
     * Short hand for getField
     * @param type $xid
     * @param type $default
     * @return string
     */
    public function xid($xid, $default="") {
        return $this->getField($xid, $default);
    }

    public function jsonSerialize() {
        return [
            "name" => $this->getName(),
            "fields" => $this->getFields(),
            "default_fields" => $this->getDefaultFields()
        ];
    }

}
