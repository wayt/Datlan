<?php

namespace Application\Controller;

use \Quokka\Mvc\Controller\AbstractController;
use \Application\Form\LoginForm;
use \Application\Form\RegisterForm;
use \Application\Model\User;
use \Application\Model\UserMapper;

class AccountController extends AbstractController {

    private $_userMapper;
    private $_request;
    private $_response;
    private $_auth;

    public function init() {

        $this->_request = $this->getApplication()->getRequest();
        $this->_response = $this->getApplication()->getResponse();
        $this->_userMapper = $this->getApplication()->getResource('db')->getMapper('user');
        $this->_auth = $this->getApplication()->getResource('auth');
    }

    public function indexAction() {

        return $this->render();
    }

    public function loginAction() {

        $form = new LoginForm();

        if ($this->_request->isPost())
        {
            if ($form->isValid($this->_request->getPost())) {

                $username = $form->getElement('username')->getValue();
                $password = $form->getElement('password')->getValue();

                if (!$this->_auth->authenticate($username, $password))
                    $form->addError('auth', 'Authentification impossible');
            }
        }

        if ($this->_auth->hasIdentity()) {

            $this->_response->redirect('/account');
            return false;
        }

        return $this->render([
            'form' => $form
        ]);
    }

    public function logoutAction() {

        $this->_auth->clearIdentity();
        $this->_response->redirect('/');

        return false;
    }

    public function registerAction() {

        $form = new RegisterForm($this->_userMapper);

        if ($this->_request->isPost())
        {
            if ($form->isValid($this->_request->getPost())) {

                $data = $this->_request->getPost();
                $user = new User();
                $user->setLastname($data['lastname']);
                $user->setFirstName($data['firstname']);
                $user->setEmail($data['email']);
                $user->setAddress($data['address']);
                $user->setCity($data['city']);
                $user->setPostcode($data['postcode']);
                $user->setUsername($data['username']);
                $user->setPassword(sha1($data['password']));
                $user->setActive(0);
                $user->setRegistered(date("Y-m-d H:i:s"));
                $user->setKey(sha1(date("Y/m/d H:i:s") . $data['email']));
                $this->_userMapper->save($user);
                $this->_response->redirect('/register-success');
                return false;
            }
        }

        return $this->render([
            'form' => $form
        ]);
    }

    public function registersuccessAction() {

        return $this->render();
    }

    public function activateaccountAction() {

        $user = $this->_userMapper->fetchOneByKey($this->_request->getParam('key', 'toto'));

        if ($user !== false && $user->getActive() == 0) {

            $user->setActive(1);
            $this->_userMapper->save($user);
        }
        else
            $user = false;

        return $this->render([
            'user' => $user
        ]);
    }
}
