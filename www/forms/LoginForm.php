<?php

namespace Application\Form;

use Quokka\Form;
use Quokka\Validate;

class LoginForm extends Form\Form {

    public function __construct() {

        $username = new Form\Element\Text('username');
        $username->setRequired(true);
        $username->addValidate(new Validate\Regex(['regex' => '/^[a-zA-Z0-9_-]{3,16}$/']));
        $username->setErrorMessage("Vous n'avez pas specifie de nom d'utilisateur.");
        $this->addElement($username);

        $password = new Form\Element\Password('password');
        $password->setRequired(true);
        $password->setErrorMessage("Vous n'avez pas specifie de mot de passe.");
        $this->addElement($password);
    }
}
