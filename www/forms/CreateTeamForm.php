<?php

namespace Application\Form;

use Quokka\Form;

class CreateTeamForm extends Form\Form {

    private $_teamMapper;

    public function __construct($teamMapper) {

        $this->_teamMapper = $teamMapper;

        $name = new Form\Element\Text('name');
        $name->setRequired(true);
        $name->setErrorMessage("Vous n'avez pas specifie de nom.");
        $this->addElement($name);

        $tag = new Form\Element\Text('tag');
        $tag->setRequired(true);
        $tag->setErrorMessage("Vous n'avez pas specifie de tag.");
        $this->addElement($tag);

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

        if ($this->_teamMapper->fetchOneByName($this->getElement('name')->getValue()) !== false)
            $this->addError('email', "Le nom de team a deja ete utilise");

        if ($this->_teamMapper->fetchOneByTag($this->getElement('tag')->getValue()) !== false)
            $this->addError('tag', "Le nom de team a deja ete utilise");

        if ($this->getElement('password')->getValue() != $this->getElement('password2')->getValue())
            $this->addError('password', "Le mot de passe n'est pas identique.");

        return !$this->hasError();
    }
}

