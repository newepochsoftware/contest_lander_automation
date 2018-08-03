<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Colugo\API;

/**
 * Description of SchemaField
 *
 * @author Christopher Mead
 */
class SchemaField extends APIObject {
    
    private $id;
    
    private $schemaId;
    
    private $fieldType;
    
    private $name;
    
    private $leadField;
    
    private $builtIn;
    
    /** The enumerated values for the field_type field */
    const COL_FIELD_TYPE_BOOLEAN = 'boolean';
    const COL_FIELD_TYPE_TEXT = 'text';
    const COL_FIELD_TYPE_MEMO = 'memo';
    const COL_FIELD_TYPE_ENUMERATION = 'enumeration';
    const COL_FIELD_TYPE_INTEGER = 'integer';
    const COL_FIELD_TYPE_DOUBLE = 'double';
    const COL_FIELD_TYPE_MONEY = 'money';
    const COL_FIELD_TYPE_EMAIL = 'email';
    const COL_FIELD_TYPE_ZIP = 'zip';
    const COL_FIELD_TYPE_STATE = 'state';
    const COL_FIELD_TYPE_COUNTRY = 'country';
    const COL_FIELD_TYPE_PHONE = 'phone';
    const COL_FIELD_TYPE_DATE = 'date';
    const COL_FIELD_TYPE_TIMESTAMP = 'timestamp';
    
    public function __construct() {
    }
    
    /**
     * 
     * @param type $id
     * @return \Colugo\API\SchemaField
     */
    public function setId($id) {
        $this->id = $id;
        return $this;
    }
    
    /**
     * 
     * @return type
     */
    public function getId() {
        return $this->id;
    }
    
    public function setSchemaId($schemaId) {
        $this->schemaId = $schemaId;
        return $this;
    }
    
    public function getSchemaId() {
        return $this->schemaId;
    }
    
    /**
     * 
     * @param type $fieldType
     * @return \Colugo\API\SchemaField
     */
    public function setFieldType($fieldType) {
        $this->fieldType = $fieldType;
        return $this;
    }
    
    public function getFieldType() {
        return $this->fieldType;
    }
    
    public function setBuiltIn($builtIn) {
        $this->builtIn = $builtIn;
        return $this;
    }
    
    public function getBuiltIn() {
        return $this->builtIn;
    }
    
    /**
     * 
     * @param type $name
     * @return \Colugo\API\SchemaField
     */
    public function setName($name) {
        $this->name = $name;
        return $this;
    }
    
    public function getName() {
        return $this->name;
    }
    
    /**
     * 
     * @param type $leadField
     * @return \Colugo\API\SchemaField
     */
    public function setLeadField($leadField) {
        $this->leadField = $leadField;
        return $this;
    }
    
    public function getLeadField() {
        return $this->leadField;
    }

    public function __getUrl() {
        if (null == $this->getId()) {
            throw new \Exception("NullSchemaIdException");
        }
        return sprintf("/schema/%d", $this->getId());
    }

    public function __postUrl() {
        return "/schema";
    }
    
    public function __putUrl() {
        if (null == $this->getId()) {
            throw new \Exception("NullSchemaIdException");
        }
        return sprintf("/schema/%d", $this->getId());
    }

}
