<?php

namespace Application\Controller;

use \Quokka\Mvc\Controller\AbstractController;
use \Application\Model\UserMapper;
use \Application\Model\TeamMapper;

class PageController extends AbstractController {

    private $_request;
    private $_response;
    private $_userMapper;
    private $_teamMapper;

    public function init() {

        $this->_request = $this->getApplication()->getRequest();
        $this->_response = $this->getApplication()->getResponse();
        $this->_userMapper = $this->getApplication()->getResource('db')->getMapper('user');
        $this->_teamMapper = $this->getApplication()->getResource('db')->getMapper('team');
    }

    public function leagueoflegendAction() {

        $registeredTeams = this->_teamMapper->countTeams();
        return $this->render([
            'registeredTeams' => $registeredTeams
        ]);
    }

    public function starcraft2Action() {

        $registeredPlayers = this->_userMapper->countInStarcarft2Tournament();
        return $this->render([
            'registeredPlayers' => $registeredPlayers
        ]);
    }
}