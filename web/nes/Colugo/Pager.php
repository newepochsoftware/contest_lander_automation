<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Colugo\API;

/**
 * Description of Pager
 *
 * @author Christopher Mead
 */
class Pager implements \Iterator {

    private $total = 0;
    private $firstIndex = 0;
    private $lastIndex = 0;
    private $page = 0;
    private $lastPage = 0;
    private $limitPerPage = 0;
    private $objectType = null;
    private $objects = [];
    private $url;

    /**
     * Creates a new pagination object
     * @param string $objectType
     * @param int $page
     * @param int $limitPerPage
     * @param string[] $query
     */
    public function __construct($objectType, $page = 1, $limitPerPage = 50, $query = [], $mode = API::LIVE_MODE) {
        switch ($objectType) {
            case "Lead":
                $this->url = "leads";
                break;
            case "Client":
                $this->url = "Client";
                break;
        }
        $this->objectType = $objectType;
        $this->page = $page;
        $this->limitPerPage = $limitPerPage;
        $query["page"] = $this->page;
        $query["limit_per_page"] = $this->limitPerPage;
        $this->url = sprintf(
                "%s/%s?%s", ($mode == API::LIVE_MODE ? \Colugo\API\API::CONNECTION_URI : API::TEST_CONNECTION_URI), $this->url, http_build_query($query)
        );
    }

    /**
     * 
     * @param \Colugo\API\API $api
     * @return \Colugo\API\Pager
     * @throws \Exception
     */
    public function fetch($api) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->url);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_USERPWD, $api->getUser()->getUserPassword());
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        curl_close($ch);
        $json = json_decode($response);
        if (is_object($json) && isset($json->exception)) {
            throw new \Exception($json->exception . ": " . $json->message);
        }
        // now loop through the json data
        $this->total = $json->total;
        $this->firstIndex = $json->first_index;
        $this->lastIndex = $json->last_index;
        $this->page = $json->page;
        $this->lastPage = $json->last_page;
        $this->limitPerPage = $json->limit_per_page;
        $listKey = strtolower($this->getObjectType()) . "s";
        if (isset($json->$listKey) && is_array($json->$listKey)) {
            $list = $json->$listKey;
            foreach ($list as $item) {
                $objName = "\\Colugo\\API\\" . ucfirst(strtolower($this->getObjectType()));
                $obj = new $objName();
                $obj->__load__from__object($item);
                array_push($this->objects, $obj);
            }
        }
        return $this;
    }

    public function getUrl() {
        return $this->url;
    }

    public function setObjectType($objectType) {
        $this->objectType = $objectType;
    }

    public function getObjectType() {
        return $this->objectType;
    }

    /**
     * Fetches all objects related to this pagination object
     * @return type[]
     */
    public function getObjects() {
        return $this->objects;
    }

    public function getTotal() {
        return $this->total;
    }

    public function setTotal($total) {
        $this->total = $total;
        return $this;
    }

    public function getFirstIndex() {
        return $this->firstIndex;
    }

    public function setFirstIndex($firstIndex) {
        $this->firstIndex = $firstIndex;
        return $this;
    }

    public function getLastIndex() {
        return $this->lastIndex;
    }

    public function setLastIndex($lastIndex) {
        $this->lastIndex = $lastIndex;
        return $this;
    }

    public function getPage() {
        return $this->page;
    }

    public function setPage($page) {
        $this->page = $page;
    }
    
    public function getLastPage() {
        return $this->lastPage;
    }

    /**
     * Returns the maxinum limit per page for
     * this pagination request
     * @return int
     */
    public function getLimitPerPage() {
        return $this->limitPerPage;
    }

    /**
     * Sets the maximum number of objects to fetch
     * per iteration of the pager
     * @param int $limitPerPage
     * @return \Colugo\API\Pager
     */
    public function setLimitPerPage($limitPerPage) {
        $this->limitPerPage = $limitPerPage;
        return $this;
    }

    public function current() {
        $var = current($this->objects);
        return $var;
    }

    public function key() {
        $var = key($this->objects);
        return $var;
    }

    public function next() {
        $var = next($this->objects);
        return $var;
    }

    public function rewind() {
        reset($this->objects);
    }

    public function valid() {
        $key = key($this->objects);
        $var = ($key !== NULL && $key !== FALSE);
        return $var;
    }

}
