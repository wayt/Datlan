<?php

namespace Application\Controller;

use \Quokka\Mvc\Controller\AbstractController;

class PaymentController extends AbstractController {

    private $_request;
    private $_response;
    private $_userMapper;

    public function init() {

        $this->_request = $this->getApplication()->getRequest();
        $this->_response = $this->getApplication()->getResponse();
        $this->_userMapper = $this->getApplication()->getResource('db')->getMapper('user');
        $this->_auth = $this->getApplication()->getResource('auth');
    }

    public function notifyAction() {

	$this->getApplication()->setLayout(null);
	$user = $this->_userMapper->fetchOneById($_POST['custom']);
	if ($user !== false) {

	    $user->setPayment(1);
	    $this->_userMapper->save($user);
            file_put_contents("toto.txt", file_get_contents("toto.txt") . $_POST['custom'] .  " a paye\n");
	}
    }

    public function successAction() {

        $user = $this->_auth->getIdentity();
	$user = $this->_userMapper->fetchOneById($user->getId());
	$this->_auth->setIdentity($user);
   	 
        return $this->render();
    }
}

