<?php

namespace Application\Form;

use Quokka\Form;

class ContactForm extends Form\Form {

    public function __construct() {

        $this->addElement(new Form\Element\Text('firstname'));
        $this->addElement(new Form\Element\Text('lastname'));
        $this->addElement(new Form\Element\Text('email'));
        $this->addElement(new Form\Element\Text('title'));
        $this->addElement(new Form\Element\Textarea('body'));
    }
}
