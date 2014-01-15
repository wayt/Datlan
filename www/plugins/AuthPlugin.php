<?php

namespace Application\Plugin;

class AuthPlugin extends \Quokka\Mvc\AbstractPlugin {

    public function preDispatch() {

        $auth = $this->getApplication()->getResource('auth');
        $this->getApplication()->getLayout()->set('auth', $auth);
    }

    public function postDispatch() {

    }
}
