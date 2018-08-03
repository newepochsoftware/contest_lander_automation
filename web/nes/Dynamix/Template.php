<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Dynamix\API;

/**
 * Description of Template
 *
 * @author Christopher Mead
 */
class Template implements \JsonSerializable {
    /**
     * Specialized Template API Token
     * @var String
     */
    private $token;
    
    /**
     * Simple identifier
     * @var type 
     */
    private $name;
    
    public function __construct($token="", $name="") {
        $this->token = $token;
        $this->name = $name;
    }
    
    public function getToken() {
        return $this->token;
    }
    
    public function getName() {
        return $this->name;
    }
    
    public function setName($name) {
        $this->name = $name;
    }
    
    public function setToken($token) {
        $this->token = $token;
    }

    public function jsonSerialize() {
        return [
            "name" => $this->getName(),
            "token" => $this->getToken()
        ];
    }

}
