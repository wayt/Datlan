<?php

namespace Application\Form;

use Quokka\Form;

class JoinTeamForm extends Form\Form {

    private $_teamMapper;

    public function __construct($teamMapper) {

        $this->_teamMapper = $teamMapper;

        $tag = new Form\Element\Text('tag');
        $tag->setRequired(true);
        $tag->setErrorMessage("Vous n'avez pas specifie de tag.");
        $this->addElement($tag);

        $password = new Form\Element\Password('password');
        $password->setRequired(true);
        $password->setErrorMessage("Vous n'avez pas specifie de mot de passe.");
        $this->addElement($password);
    }

    public function isValid($data) {

        if (!parent::isValid($data))
            return false;

        if ($this->_teamMapper->fetchOneByPassword($this->getElement('tag')->getValue(), sha1($this->getElement('password')->getValue())) === false)
            $this->addError('join', "Impossible de rejoindre la team");

        return !$this->hasError();
    }
}


