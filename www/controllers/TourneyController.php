<?php

namespace Application\Controller;

use \Quokka\Mvc\Controller\AbstractController;
use \Application\Model\User;
use \Application\Model\UserMapper;
use \Application\Model\Team;
use \Application\Model\TeamMapper;

class TourneyController extends AbstractController {

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

        $registeredTeams = $this->_teamMapper->countTeams();
        $registeredTeamsList = array()
        $teamsofList = $this->_teamMapper->fetchAllTeams();
        var_dump($teamsofList);
        foreach ($teamsofList as $team) {
            $players = $this->_userMapper->fetchAllByTeam($team->getId());
            registeredPlayersList[] = array(
                "name"  =>  $team->getName(),
                "players"   => $players
            );
        }
        $validatedTeams = 0;
        return $this->render([
            'registeredTeams' => $registeredTeams,
            'registeredTeamsList' => $registeredTeamsList,
            'validatedTeams' => $validatedTeams
        ]);
    }

    public function starcraft2Action() {

        $registeredPlayers = $this->_userMapper->countInStarcarft2Tournament();
        $registeredPlayersList = $this->_userMapper->fetchAllByStarcraft2Tournament();
        $validatedPlayers = 0;
        return $this->render([
            'registeredPlayers' => $registeredPlayers,
            'registeredPlayersList' => $registeredPlayersList,
            'validatedPlayers' => $validatedPlayers
        ]);
    }
}
