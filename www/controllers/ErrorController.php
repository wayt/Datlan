<?php

namespace Application\Controller;

use \Quokka\Mvc\Controller\AbstractController;
use Application\Form\ContactForm;

class ErrorController extends AbstractController {

    private $_request;
    private $_response;

    public function init() {

        $this->_request = $this->getApplication()->getRequest();
        $this->_response = $this->getApplication()->getResponse();
    }

    public function indexAction() {

        return $this->render();
    }
}
