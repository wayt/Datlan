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

    public function standsAction() {

        return $this->render();
    }

    public function infosAction() {

        return $this->render();
    }

    public function partnersAction() {

        return $this->render();
    }

    public function mentionslegalesAction() {

        return $this->render();
    }

    public function contactAction() {

        $form = new ContactForm();

        if ($this->_request->isPost())
        {
            if ($form->isValid($this->_request->getPost())) {

                $headers = 'From: ' . $form->getElement('email')->getValue() . "\r\n" .
                           'Reply-To: ' . $form->getElement('email')->getValue() . "\r\n" .
                           'Content-type: text/html; charset=iso-8859-1' . "\r\n" .
                           'X-Mailer: PHP/' . phpversion();

                mail('contact@datlan.eu, fabien.casters@epitech.eu, maxime.ginters@epitech.eu, vincent.leroy@epitech.eu', 'Un message du site de Datlan',
                    "<p>Email :" .$form->getElement('email')->getValue() . "</p>" .
                    "<p>Firstname :" .$form->getElement('firstname')->getValue() . "</p>" .
                    "<p>Lastname :" .$form->getElement('lastname')->getValue() . "</p>" .
                    "<p>Title :" .$form->getElement('title')->getValue() . "</p>" .
                    "<p>Content :" .$form->getElement('body')->getValue() . "</p>",
                    $headers
                );
                $this->_response->redirect('/contact-success');
            }
        }

        return $this->render([
            'form' => $form
        ]);
    }

    public function contactsuccessAction() {

        return $this->render();
    }

    public function confidentialityAction() {

        return $this->render();
    }
}
