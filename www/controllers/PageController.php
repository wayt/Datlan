<?php

namespace Application\Controller;

use \Quokka\Mvc\Controller\AbstractController;
use Application\Form\ContactForm;

class PageController extends AbstractController {

    private $_request;
    private $_response;

    public function init() {

        $this->_request = $this->getApplication()->getRequest();
        $this->_response = $this->getApplication()->getResponse();
    }

    public function indexAction() {

        return $this->render();
    }

    public function standAction() {

        return $this->render();
    }

    public function contactAction() {

        $form = new ContactForm();

        if ($this->_request->isPost())
        {
            if ($form->isValid($this->_request->getPost())) {

                $headers = 'From: no-reply@datlan.eu' . "\r\n" .
                           'Reply-To: no-reply@datlan.eu' . "\r\n" .
                           'Content-type: text/html; charset=iso-8859-1' . "\r\n" .
                           'X-Mailer: PHP/' . phpversion();

                mail($user->getEmail(), 'Datlan - Activation de votre compte',
                    "<p><a href='http://www.datlan.eu/activate-account?key=" . $user->getKey() . "'>Lien d'activation de votre compte</a></p>",
                    $headers
                );
            }
        }

        return $this->render([
            'form' => $form
        ]);
    }
}
