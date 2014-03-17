<?php

namespace Application\Controller;

use \Quokka\Mvc\Controller\AbstractController;

class PaymentController extends AbstractController {

    private $_request;
    private $_response;

    public function init() {

        $this->_request = $this->getApplication()->getRequest();
        $this->_response = $this->getApplication()->getResponse();
    }

    public function notifyAction() {

        file_get_contents("toto.txt", "coucou\n");
        return $this->render();
    }
}

