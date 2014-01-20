<?php

namespace Application\Controller;

use \Quokka\Mvc\Controller\AbstractController;

class NewsController extends AbstractController {

    private $_request;
    private $_response;
    private $_newsMapper;

    public function init() {

        $this->_request = $this->getApplication()->getRequest();
        $this->_response = $this->getApplication()->getResponse();
        $this->_newsMapper = $this->getApplication()->getResource('db')->getMapper('news');
    }

    public function indexAction() {

        $news = $this->_newsMapper->fetchAllNews();
        return $this->render(['news' => $news]);
    }
}
