<?php

namespace Application\Form;

use Quokka\Form;

class JoinTeamForm extends Form\Form {

    private $_teamMapper;
    private $_userMapper;

    public function __construct($teamMapper, $userMapper) {

        $this->_teamMapper = $teamMapper;
        $this->_userMapper = $userMapper;

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

        $team = $this->_teamMapper->fetchOneByPassword($this->getElement('tag')->getValue(), sha1($this->getElement('password')->getValue()));

        if ($team === false)
            $this->addError('join', "Impossible de rejoindre la team");
        if ($team !== false && $this->_userMapper->countInTeam($team->getId()) == 5)
            $this->addError('join', "La team est complete !");

        return !$this->hasError();
    }
}


