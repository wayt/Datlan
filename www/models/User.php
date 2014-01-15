<?php

namespace Application\Model;

class User extends \Quokka\Database\AbstractEntity {

    private $_id = null;
    private $_active;
    private $_key;
    private $_username;
    private $_group = 'user';
    private $_password;
    private $_email;
    private $_lastname;
    private $_firstname;
    private $_address;
    private $_postcode;
    private $_city;
    private $_registered;

    public function __call($name, $args) {

        if (substr($name, 0, 3) == 'get') {

            $prop = '_' . strtolower(substr($name, 3));
            return $this->$prop;
        }
        else if (substr($name, 0, 3) == 'set') {

            $prop = '_' . strtolower(substr($name, 3));
            $this->$prop = $args[0];
        }
    }
}
