<?php

namespace Application\Controller;

use \Quokka\Mvc\Controller\AbstractController;
use \Application\Form\LoginForm;
use \Application\Form\RegisterForm;
use \Application\Form\CreateTeamForm;
use \Application\Form\JoinTeamForm;
use \Application\Model\User;
use \Application\Model\UserMapper;
use \Application\Model\Team;
use \Application\Model\TeamMapper;

class AccountController extends AbstractController {

    private $_userMapper;
    private $_teamMapper;
    private $_request;
    private $_response;
    private $_auth;

    public function init() {

        $this->_request = $this->getApplication()->getRequest();
        $this->_response = $this->getApplication()->getResponse();
        $this->_userMapper = $this->getApplication()->getResource('db')->getMapper('user');
        $this->_teamMapper = $this->getApplication()->getResource('db')->getMapper('team');
        $this->_auth = $this->getApplication()->getResource('auth');
    }

    public function indexAction() {

        if (!$this->_auth->hasIdentity()) {

            $this->_response->redirect('/login');
            return false;
        }

        $createForm = new CreateTeamForm($this->_teamMapper, $this->_userMapper);
        $joinForm = new JoinTeamForm($this->_teamMapper);
        $user = $this->_auth->getIdentity();
        $team = $this->_teamMapper->fetchOneById($user->getTeam());
        $usersTeam = $this->_userMapper->fetchAllByTeam($user->getTeam());

        // Unsubscription LoL
        if ($this->_request->getParam('id', false) && $user->getTeam() == $this->_request->getQuery('id')) {

            $user->setTeam(0);
            $this->_userMapper->save($user);
            if ($this->_userMapper->countInTeam($this->_request->getQuery('id')) == 0)
                $this->_teamMapper->removeById($this->_request->getQuery('id'));

            $this->_response->redirect('/account');
            return false;
        }

        if ($this->_request->getParam('starcraft', false) && $user->getTeam() == '0') {

            if ($this->_request->getQuery('starcraft') == 'y')
                $user->setStarcraft(1);
            else if ($this->_request->getQuery('starcraft') == 'n')
                $user->setStarcraft(0);
            $this->_userMapper->save($user);
            $this->_response->redirect('/account');
            return false;
        }

        if ($this->_request->isPost()) {

            // Create a team
            if ($this->_request->getParam('submit-create', false) && $user->getTeam() == '0') {

                if ($createForm->isValid($this->_request->getPost())) {

                    $data = $this->_request->getPost();
                    $team = new Team();
                    $team->setName($data['name']);
                    $team->setTag($data['tag']);
                    $team->setPassword(sha1($data['password']));
                    $this->_teamMapper->save($team);
                    $user->setTeam($team->getId());
                    $this->_userMapper->save($user);
                    $this->_response->redirect('/account');
                    return false;
                }
            }

            // Join a team
            if ($this->_request->getParam('submit-join', false) && $user->getTeam() == '0') {

                if ($joinForm->isValid($this->_request->getPost())) {

                    $data = $this->_request->getPost();
                    $team = $this->_teamMapper->fetchOneByPassword($data['tag'], sha1($data['password']));
                    if ($this->_userMapper->countInTeam($team->getId()) < 5) {

                        $user->setTeam($team->getId());
                        $this->_userMapper->save($user);
                        $this->_response->redirect('/account');
                        return false;
                    }
                }
            }
        }

        return $this->render([
            'createForm' => $createForm,
            'joinForm' => $joinForm,
            'user' => $user,
            'team' => $team,
            'usersTeam' => $usersTeam
        ]);
    }

    public function loginAction() {

        $form = new LoginForm();

        if ($this->_request->isPost()) {

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
                $user->setLastname($form->getElement('lastname')->getValue());
                $user->setFirstName($form->getElement('firstname')->getValue());
                $user->setEmail($form->getElement('email')->getValue());
                $user->setAddress($form->getElement('address')->getValue());
                $user->setCity($form->getElement('city')->getValue());
                $user->setPostcode($form->getElement('postcode')->getValue());
                $user->setUsername($form->getElement('username')->getValue());
                $user->setPassword(sha1($form->getElement('password')->getValue()));
                $user->setActive(0);
                $user->setRegistered(date("Y-m-d H:i:s"));
                $user->setKey(sha1(date("Y/m/d H:i:s") . $user->getEmail()));
                $user->setTeam(0);
                $user->setStarcraft(0);
                $user->setBorn($form->getElement('born')->getValue());
                $this->_userMapper->save($user);

                $headers = 'From: no-reply@datlan.eu' . "\r\n" .
                           'Reply-To: no-reply@datlan.eu' . "\r\n" .
                           'Content-type: text/html; charset=iso-8859-1' . "\r\n" .
                           'X-Mailer: PHP/' . phpversion();

                mail($user->getEmail(), 'Datlan - Activation de votre compte',
                    "<p><a href='http://www.datlan.eu/activate-account?key=" . $user->getKey() . "'>Lien d'activation de votre compte</a></p>",
                    $headers
                );
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
