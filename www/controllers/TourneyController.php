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
        $registeredTeamsList = array();
        $registeredTeamsListTemp = $this->_teamMapper->fetchAllTeams();
        $confirmed = 0;
        foreach ($registeredTeamsListTemp as $team) {
            $o = 0;
            $players = $this->_userMapper->fetchAllByTeam($team->getId());
	    foreach($players as $player) {
                if ($player->getPayment() == 1)
                    $o++;
            }
            if ($o == 5)
                $confirmed++;
            $registeredTeamsList[] = array(
                "name"  =>  $team->getName(),
                "players"   => $players
            );
        }
        return $this->render([
            'registeredTeams' => $registeredTeams,
            'registeredTeamsList' => $registeredTeamsList,
            'validedTeams' => $confirmed
        ]);
    }

    public function starcraft2Action() {

        $registeredPlayers = $this->_userMapper->countInStarcarft2Tournament();
        $registeredPlayersList = $this->_userMapper->fetchAllByStarcraft2Tournament();
        $validedPlayers = 0;
        foreach ($registeredPlayersList as $player) {
            if ($player->getPayment() == 1)
                $validedPlayers++;
        }
        return $this->render([
            'registeredPlayers' => $registeredPlayers,
            'registeredPlayersList' => $registeredPlayersList,
            'validedPlayers' => $validedPlayers
        ]);
    }
}
