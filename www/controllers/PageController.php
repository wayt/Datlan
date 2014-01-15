<?php

namespace Application\Controller;

use \Quokka\Mvc\Controller\AbstractController;
use Application\Form\ContactForm;

class PageController extends AbstractController {

    public function init() {

    }

    public function indexAction() {

        return $this->render();
    }

    public function standAction() {

        return $this->render();
    }

    public function contactAction() {

        $form = new ContactForm();

        return $this->render([
            'form' => $form
        ]);
    }
}
