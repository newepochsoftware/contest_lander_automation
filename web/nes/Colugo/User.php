<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Colugo\API;

/**
 * Description of User
 *
 * @author Christopher Mead
 */
class User {
    /**
     * User identifier token, i.e. email address
     * @var string
     */
    private $username;
    
    /**
     * Dynamix provided developer token
     * @var string
     */
    private $token;
    
    public function __construct($username, $token) {
        $this->username = $username;
        $this->token = $token;
    }
    
    public function getUserPassword() {
        return sprintf("%s:%s", $this->username, $this->token);
    }
    
    public function getUsername() {
        return $this->username;
    }
    
    public function getToken() {
        return $this->token;
    }
    
    public function __toString() {
        return $this->getUserPassword();
    }
}