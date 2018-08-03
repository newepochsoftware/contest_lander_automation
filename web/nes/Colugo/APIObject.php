<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Colugo\API;

/**
 * Description of APIObject
 *
 * @author Christopher Mead
 */
abstract class APIObject implements \JsonSerializable {

    public function __load__from__object($object) {
        foreach ($object as $attr => $value) {
            // we convert city_mixed_case to setCityMixedCase
            $method = "set" . $this->_convertAttributeToCamelCase($attr);
            if (method_exists($this, $method) &&
                    is_callable([$this, $method])) {
                call_user_func_array([$this, $method], [$value]);
            }
        }
    }
    
    public abstract function __getUrl();
    public abstract function __postUrl();
    public abstract function __putUrl();

    private function _convertAttributeToCamelCase($attr, $capitalizeFirstCharacter = true) {
        $meth = str_replace(' ', '', ucwords(str_replace('_', ' ', $attr)));

        if (!$capitalizeFirstCharacter) {
            $meth[0] = strtolower($meth[0]);
        }
        return $meth;
    }
    
    public function jsonSerialize() {
        $fields = [];
        $methods = get_class_methods(get_class($this));
        foreach ($methods as $method) {
            if (preg_match("/^get[A-Z]/", $method)) {
                $value = call_user_func([$this, $method]);
                $attr = substr(strtolower(preg_replace("/([A-Z])/", "_\\1", $method)), 4);
                $fields[$attr] = $value;
            }
        }
        
        return $fields;
    }

}
