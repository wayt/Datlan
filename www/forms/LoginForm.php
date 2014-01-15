<?php

namespace Application\Form;

use Quokka\Form;

class LoginForm extends Form\Form {

    public function __construct() {

        $this->addElement(new Form\Element\Text('username'));
        $this->addElement(new Form\Element\Password('password'));
    }
}
