<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Dynamix\API;

/**
 * Description of Link
 *
 * @author Christopher Mead
 */
class Link implements \JsonSerializable {

    private $name;
    private $url;
    private $description;
    private $tags = [];
    private $weights = [];

    public function __construct() {
        $this->weights["mobile"] = 0;
        $this->weights["tablet"] = 0;
        $this->weights["desktop"] = 0;
    }

    public function getMobileWeight() {
        return $this->weights["mobile"];
    }

    public function getTabletWeight() {
        return $this->weights["tablet"];
    }

    public function getDesktopWeight() {
        return $this->weights["desktop"];
    }

    /**
     * 
     * @param type $weight
     * @return \Dynamix\API\Link
     */
    public function setMobileWeight($weight) {
        $this->weights["mobile"] = $weight;
        return $this;
    }

    /**
     * 
     * @param type $weight
     * @return \Dynamix\API\Link
     */
    public function setTabletWeight($weight) {
        $this->weights["tablet"] = $weight;
        return $this;
    }

    /**
     * 
     * @param type $weight
     * @return \Dynamix\API\Link
     */
    public function setDesktopWeight($weight) {
        $this->weights["desktop"] = $weight;
        return $this;
    }

    /**
     * 
     * @param string[] $tags
     * @return \Dynamix\API\Link
     */
    public function setTags($tags) {
        $this->tags = $tags;
        return $this;
    }

    public function getTags() {
        return $this->tags;
    }

    public function setUrl($url) {
        $this->url = $url;
        return $this;
    }

    public function getUrl() {
        return $this->url;
    }

    public function setDescription($description) {
        $this->description = $description;
        return $this;
    }

    public function getDescription() {
        return $this->description;
    }

    public function setName($name) {
        $this->name = $name;
        return $this;
    }

    public function getName() {
        return $this->name;
    }

    public function jsonSerialize() {
        return [
            "name" => $this->getName(),
            "url" => $this->getUrl(),
            "description" => $this->getDescription(),
            "tags" => $this->getTags(),
            "weights" => [
                "mobile" => $this->getMobileWeight(),
                "tablet" => $this->getTabletWeight(),
                "desktop" => $this->getDesktopWeight()
            ]
        ];
    }

}
