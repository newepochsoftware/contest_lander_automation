<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Colugo\API;

/**
 * Dynamix API interface
 *
 * @author Christopher Mead
 */
class API {

    const TEST_CONNECTION_URI = "http://testing.colugo.com/api/v1";
    const CONNECTION_URI = "https://glow.fish/api/v1";
    
    const LIVE_MODE = 1;
    const TEST_MODE = 2;

    /**
     *
     * @var \Dynamix\API\User
     */
    private $user;
    private $username;
    private $developerKey;
    
    private $mode = self::LIVE_MODE;
    
    private $uri;

    /**
     * Constructs a new API interface
     * @param \Dynamix\API\User $user
     */
    public function __construct($user) {
        $this->user = $user;
        $this->username = $user->getUsername();
        $this->developerKey = $user->getToken();
        $this->uri = self::CONNECTION_URI;
    }
    
    public function setMode($mode) {
        switch ($mode) {
            case self::LIVE_MODE:
            case self::TEST_MODE:
                $this->mode = $mode;
                break;
            default:
                break;
        }
        if ($this->mode == self::TEST_MODE) {
            $this->uri = self::TEST_CONNECTION_URI;
        }
    }
    
    /**
     * Wrapper for creating a pager object
     * @param string $objectType
     * @param int $page
     * @param int $limitPerPage
     * @param string $query
     */
    public function paginate($objectType, $page = 1, $limitPerPage = 50, $query = []) {
        $pager = new Pager($objectType, $page, $limitPerPage, $query, $this->mode);
        $pager->fetch($this);
        return $pager;
    }

    /**
     * Executes a put request on the API
     * @param string $path
     * @param type $object
     * @return string
     */
    private function _get($path, $data) {
        $ch = curl_init();
        $url = sprintf("%s%s", $this->uri, $path);
        if (sizeof($data) != 0) {
            $url .= "?" . http_build_query($data);
        }
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_USERPWD, sprintf("%s:%s", $this->username, $this->developerKey));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        curl_close($ch);
        $json = json_decode($response);
        if (is_object($json) && isset($json->exception)) {
            throw new \Exception($json->exception . ": " . $json->message);
        }
        return $json;
    }

    /**
     * Executes a put request on the API
     * @param string $path
     * @param type $object
     * @return string
     */
    private function _put($path, $object) {
        $data_json = json_encode($object);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, sprintf("%s%s", $this->uri, $path));
        curl_setopt($ch, CURLOPT_HTTPHEADER, $this->getHeaders(strlen($data_json)));
        curl_setopt($ch, CURLOPT_USERPWD, sprintf("%s:%s", $this->username, $this->developerKey));
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_json);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        curl_close($ch);
        $json = json_decode($response);
        if (is_object($json) && isset($json->exception)) {
            throw new \Exception($json->exception . ": " . $json->message);
        }
        return $json;
    }

    /**
     * Executes a post request on the API
     * @param string $path
     * @param type $object
     * @return string
     */
    private function _post($path, $object, $opts) {
        $data_json = json_encode($object);
        $ch = curl_init();
        if (is_array($opts)) {
            $query = http_build_query($opts);
            $path .= "?$query";
        }
        curl_setopt($ch, CURLOPT_URL, sprintf("%s%s", $this->uri, $path));
        curl_setopt($ch, CURLOPT_HTTPHEADER, $this->getHeaders(strlen($data_json)));
        curl_setopt($ch, CURLOPT_USERPWD, sprintf("%s:%s", $this->username, $this->developerKey));
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_json);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        // echo "RESPONSE: $response\n";
        curl_close($ch);
        $json = json_decode($response);
        if (is_object($json) && isset($json->exception)) {
            throw new \Exception($json->exception . ": " . $json->message);
        }
        return $json;
    }

    /**
     * Executes a delete request on the API
     * @param string $path
     * @param type $object
     * @return string
     */
    private function _delete($path, $object, $opts) {
        $data_json = json_encode($object);
        $ch = curl_init();
        if (is_array($opts)) {
            $query = http_build_query($opts);
            $path .= "?$query";
        }
        curl_setopt($ch, CURLOPT_URL, sprintf("%s%s", $this->uri, $path));
        curl_setopt($ch, CURLOPT_HTTPHEADER, $this->getHeaders(strlen($data_json)));
        curl_setopt($ch, CURLOPT_USERPWD, sprintf("%s:%s", $this->username, $this->developerKey));
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'DELETE');
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_json);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        // echo "RESPONSE: $response\n";
        curl_close($ch);
        $json = json_decode($response);
        if (is_object($json) && isset($json->exception)) {
            throw new \Exception($json->exception . ": " . $json->message);
        }
        return $json;
    }

    private function getHeaders($len = 0) {
        $header = [];
        $header[] = "Content-Length: $len";
        $header[] = "Content-Type: application/json";
        return $header;
    }
    
    /**
     * 
     * @param \Colugo\API\APIObject $object
     * @return type
     */
    public function fetch($object) {
        if ($object instanceof \Colugo\API\APIObject) {
            $data = $this->_get($object->__getUrl(), []);
            $object->__load__from__object($data);
            return $object;
        } else {
            throw new \Exception("UnknownObjectTypeException: ".get_class($object));
        }
    }

    public function delete($object, $opts = []) {
        if ($object instanceof \Colugo\API\APIObject) {
            $data = $this->_delete($object->__putUrl(), $object, $opts);
        } else {
            throw new \Exception("UnknownObjectTypeException: " . get_class($object));
        }
    }
    
    /**
     * Alternate method to fetch
     * @param type $object
     * @return type
     */
    public function get($object) {
        return $this->fetch($object);
    }
    
    public function create($object, $opts = []) {
        if ($object instanceof \Colugo\API\APIObject) {
            $data = $this->_post($object->__postUrl(), $object, $opts);
            $object->__load__from__object($data);
        } else {
            throw new \Exception("UnknownObjectTypeException: ".get_class($object));
        }
        return $object;
    }
    
    public function post($object, $opts = []) {
        return $this->create($object, $opts);
    }
    
    public function update($object) {
        if ($object instanceof \Colugo\API\APIObject) {
            $data = $this->_put($object->__putUrl(), $object);
            $object->__load__from__object($data);
        } else {
            throw new \Exception("UnknownObjectTypeException: ".get_class($object));
        }
        return $object;
    }
    
    public function put($object) {
        return $this->update($object);
    }
    
    
    /**
     * Fetches the API's current user
     * @return \Colugo\API\User
     */
    public function getUser() {
        return $this->user;
    }

    public static function autoloader($name) {
        switch ($name) {
            case "Colugo\\API\\User":
                require_once(__DIR__ . "/User.php");
                break;
            case "Colugo\\API\\APIObject":
                require_once(__DIR__ . "/APIObject.php");
                break;
            case "Colugo\\API\\Client":
                require_once(__DIR__ . "/Client.php");
                break;
                break;
            case "Colugo\\API\\ClientContactInfo":
                require_once(__DIR__ . "/ClientContactInfo.php");
                break;
            case "Colugo\\API\\Lead":
                require_once(__DIR__ . "/Lead.php");
                break;
            case "Colugo\\API\\Zip":
                require_once(__DIR__ . "/Zip.php");
                break;
            case "Colugo\\API\\SchemaField":
                require_once(__DIR__ . "/SchemaField.php");
                break;
            case "Colugo\\API\\Pager":
                require_once(__DIR__ . "/Pager.php");
                break;
            default:
                break;
        }
    }

}

spl_autoload_register('\\Colugo\\API\\API::autoloader');
