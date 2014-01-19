<?php

namespace Application\Model;

class Team extends \Quokka\Database\AbstractEntity {

    private $_id = null;
    private $_name;
    private $_tag;
    private $_password;

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
