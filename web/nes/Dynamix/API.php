<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Dynamix\API;

/**
 * Dynamix API interface
 *
 * @author Christopher Mead
 */
class API {

    const TEST_CONNECTION_URI = "http://testing.dynamicsite.com/api/v1";
    const CONNECTION_URI = "https://dynamix.systems/api/v1";
    
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
        if ($this->isSessionStarted() === false) {
            session_start();
        }
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

    private function isSessionStarted() {
        if (php_sapi_name() !== 'cli') {
            if (version_compare(phpversion(), '5.4.0', '>=')) {
                return session_status() === PHP_SESSION_ACTIVE ? true : false;
            } else {
                return session_id() === '' ? false : true;
            }
        }
        return false;
    }

    /**
     * Executes a put request on the API
     * @param string $path
     * @param type $object
     * @return string
     */
    private function get($path, $data) {
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
    private function put($path, $object) {
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
    private function post($path, $object) {
        $data_json = json_encode($object);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, sprintf("%s%s", $this->uri, $path));
        curl_setopt($ch, CURLOPT_HTTPHEADER, $this->getHeaders(strlen($data_json)));
        curl_setopt($ch, CURLOPT_USERPWD, sprintf("%s:%s", $this->username, $this->developerKey));
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
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

    private function getHeaders($len = 0) {
        $header = [];
        $header[] = "Content-Length: $len";
        $header[] = "Content-Type: application/json";
        return $header;
    }

    /**
     * Redirects based on traffic allocation
     * if necessary
     * @param \Dynamix\API\Template $template
     */
    public function allocateTraffic($template) {
        
    }

    /**
     * Loan next link
     * @param String $tags
     * @param String $device
     */
    public function loadLink($tags, $device = "m", $vars = null) {
        if (!is_array($vars)) {
            $vars = [];
        }
        $data = $this->get("/link", [
            "tags" => $tags,
            "device" => $device
        ]);
        $link = $data->link;
        if (null != $link) {
            $apiLink = new Link();
            $apiLink->setName($link->name);
            $apiLink->setTags($link->tags);
            $apiLink->setDescription($link->description);
            $apiLink->setMobileWeight($link->weights->mobile);
            $apiLink->setTabletWeight($link->weights->tablet);
            $apiLink->setDesktopWeight($link->weights->desktop);
            $apiLink->setUrl(preg_replace_callback(
                    "/\[\[(\w+)\]\]/", function($match) use ($vars) {
                $key = $match[1];
                if (isset($vars[$key])) {
                    return urlencode($vars[$key]);
                }
                return "";
            }, $link->url));
            return $apiLink;
        } else {
            return null;
        }
    }

    /**
     * 
     * @param \Dynamix\API\Template $template
     * @param \Dynamix\API\Profile $profile
     * @return \Dynamix\API\Profile
     */
    public function loadProfile($template, $profile = null) {
        if (null == $profile) {
            // ok, let's try to do it then off the xid
            // else, use "default"
            $xid = filter_input(INPUT_GET, "xid");
            if (null == $xid || "" == $xid) {
                $xid = filter_input(INPUT_GET, "profile");
            }
            // if it's still null, let's check the session
            if (null == $xid || "" == $xid) {
                if (isset($_SESSION["dynamix.profile.xid"])) {
                    $xid = $_SESSION["dynamix.profile.xid"];
                }
            }
            if (null != $xid && "" != $xid) {
                $_SESSION["dynamix.profile.xid"] = $xid;
                $profile = new \Dynamix\API\Profile($xid);
            } else {
                $_SESSION["dynamix.profile.xid"] = "default";
                $profile = new \Dynamix\API\Profile("default");
            }
        }

        $data = $this->get(
                "/profile", [
            "template_token" => $template->getToken(),
            "template_name" => $template->getName(),
            "profile" => $profile->getName()
        ]);
        // update the template data
        $templateObj = $data->template;
        $template->setName($templateObj->name);
        $template->setToken($templateObj->token);
        // update the profile info
        $defaultObj = $data->default_profile;
        $profileObj = $data->profile;
        $profile->setName($profileObj->name);
        $profile->setFields(json_decode(json_encode($profileObj->fields), true));
        $profile->setDefaultFields(json_decode(json_encode($defaultObj->fields), true));

        return $profile;
    }

    /**
     * Fetches the API's current user
     * @return \Dynamix\API\User
     */
    public function getUser() {
        return $this->user;
    }

    public static function autoloader($name) {
        switch ($name) {
            case "Dynamix\\API\\User":
                require_once(__DIR__ . "/User.php");
                break;
            case "Dynamix\\API\\Profile":
                require_once(__DIR__ . "/Profile.php");
                break;
            case "Dynamix\\API\\Template":
                require_once(__DIR__ . "/Template.php");
                break;
            case "Dynamix\\API\\Link":
                require_once(__DIR__ . "/Link.php");
                break;
            default:
                break;
        }
    }

}

spl_autoload_register('\\Dynamix\\API\\API::autoloader');

