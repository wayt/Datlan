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

    public function isValid($post) {
        if (!parent::isValid($post))
            return false;


        if ($post["recaptcha_response_field"]) {
            $resp = recaptcha_check_answer (CAPTCHA_PRIVATE_KEY,
                $_SERVER["REMOTE_ADDR"],
                $post["recaptcha_challenge_field"],
                $post["recaptcha_response_field"]);

            if (!$resp->is_valid) {
                $this->addError('Captcha', 'Captcha invalide');
                return false;
            }
        }
        return true;
    }
}
