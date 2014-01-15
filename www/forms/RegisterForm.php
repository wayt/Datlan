<?php

namespace Application\Form;

use Quokka\Form;

class RegisterForm extends Form\Form {

    private $_userMapper;

    public function __construct($userMapper) {

        $this->_userMapper = $userMapper;

        $lastname = new Form\Element\Text('lastname');
        $lastname->setRequired(true);
        $lastname->setErrorMessage("Vous n'avez pas specifie de nom.");
        $this->addElement($lastname);

        $firstname = new Form\Element\Text('firstname');
        $firstname->setRequired(true);
        $firstname->setErrorMessage("Vous n'avez pas specifie de prenom.");
        $this->addElement($firstname);

        $email = new Form\Element\Email('email');
        $email->setRequired(true);
        $email->setErrorMessage("Vous n'avez pas specifie d'adresse mail valide.");
        $this->addElement($email);

        $address = new Form\Element\Text('address');
        $address->setRequired(true);
        $address->setErrorMessage("Vous n'avez pas specifie d'adresse postale.");
        $this->addElement($address);

        $postcode = new Form\Element\Text('postcode');
        $postcode->setRequired(true);
        $postcode->setErrorMessage("Vous n'avez pas specifie de code postal.");
        $this->addElement($postcode);

        $city = new Form\Element\Text('city');
        $city->setRequired(true);
        $city->setErrorMessage("Vous n'avez pas specifie de ville.");
        $this->addElement($city);

        $username = new Form\Element\Text('username');
        $username->setRequired(true);
        $username->setErrorMessage("Vous n'avez pas specifie de nom d'utilisateur.");
        $this->addElement($username);

        $password = new Form\Element\Password('password');
        $password->setRequired(true);
        $password->setErrorMessage("Vous n'avez pas specifie de mot de passe.");
        $this->addElement($password);

        $password2 = new Form\Element\Password('password2');
        $password2->setRequired(true);
        $password2->setErrorMessage("Vous n'avez pas specifie de confirmation de mot de passe.");
        $this->addElement($password2);
    }

    public function isValid($data) {

        if (!parent::isValid($data))
            return false;

        if ($this->getElement('password')->getValue() != $this->getElement('password2')->getValue())
            $this->addError('password', "Le mot de passe n'est pas identique.");

        if ($this->_userMapper->fetchOneByEmail($this->getElement('email')->getValue()) === false)
            $this->addError('email', "Le mail a deja ete utilise");

        if ($this->_userMapper->fetchOneByUsername($this->getElement('username')->getValue()) === false)
            $this->addError('username', "Le nom d'utilisateur a deja ete utilise");

        return !$this->hasError();
    }
}
