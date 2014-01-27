<?php

namespace Application\Form;

use Quokka\Form;
use Quokka\Validate;

class RegisterForm extends Form\Form {

    private $_userMapper;

    public function __construct($userMapper) {

        $this->_userMapper = $userMapper;

        $lastname = new Form\Element\Text('lastname');
        $lastname->setRequired(true);
        $lastname->setErrorMessage("Vous n'avez pas specifie de nom.");
        $this->addElement($lastname);

        $firstname = new Form\Element\Text('firstname');
        $firstname->setRequired(true);
        $firstname->setErrorMessage("Vous n'avez pas specifie de prenom.");
        $this->addElement($firstname);

        $email = new Form\Element\Email('email');
        $email->setRequired(true);
        $email->setErrorMessage("Vous n'avez pas specifie d'adresse mail valide.");
        $this->addElement($email);

        $address = new Form\Element\Text('address');
        $address->setRequired(true);
        $address->setErrorMessage("Vous n'avez pas specifie d'adresse postale.");
        $this->addElement($address);

        $postcode = new Form\Element\Text('postcode');
        $postcode->setRequired(true);
        $postcode->addValidate(new Validate\Numeric());
        $postcode->addValidate(new Validate\StringLength(['min' => 4, 'max' => 6]));
        $postcode->setErrorMessage("Vous n'avez pas specifie de code postal.");
        $this->addElement($postcode);

        $city = new Form\Element\Text('city');
        $city->setRequired(true);
        $city->setErrorMessage("Vous n'avez pas specifie de ville.");
        $this->addElement($city);

        $username = new Form\Element\Text('username');
        $username->setRequired(true);
        $username->addValidate(new Validate\Regex(['regex' => '/^[a-zA-Z0-9_-]{3,16}$/']));
        $username->setErrorMessage("Vous n'avez pas specifie de nom d'utilisateur.");
        $this->addElement($username);

        $password = new Form\Element\Password('password');
        $password->setRequired(true);
        $password->setErrorMessage("Vous n'avez pas specifie de mot de passe.");
        $this->addElement($password);

        $password2 = new Form\Element\Password('password2');
        $password2->setRequired(true);
        $password2->setErrorMessage("Vous n'avez pas specifie de confirmation de mot de passe.");
        $this->addElement($password2);

        $born = new Form\Element\Text('born');
        $born->setRequired(true);
        $born->addValidate(new Validate\Regex(['regex' => '`^\d{1,2}/\d{1,2}/\d{4}$`']));
        $born->setErrorMessage("Vous n'avez pas specifie de date de naissance.");
        $this->addElement($born);
    }

    public function isValid($data) {

        if (!parent::isValid($data))
            return false;

        if ($this->getElement('password')->getValue() != $this->getElement('password2')->getValue())
            $this->addError('password', "Le mot de passe n'est pas identique.");

        if ($this->_userMapper->fetchOneByEmail($this->getElement('email')->getValue()) !== false)
            $this->addError('email', "Le mail a deja ete utilise");

        if ($this->_userMapper->fetchOneByUsername($this->getElement('username')->getValue()) !== false)
            $this->addError('username', "Le nom d'utilisateur a deja ete utilise");

        // Blockage email
        if (strlen(EMAIL_BLACKLIST) > 0) {

            $providers = explode(' ', EMAIL_BLACKLIST);
            foreach ($providers as $prov) {
                if (preg_match("#^[\w.-]+@" . $prov . "#", $this->getElement('email')->getValue()))
                    $this->addError('email', 'Merci de ne pas utiliser une adresse de type ' . $prov . '.');
            }
        }

        if ($data["recaptcha_response_field"]) {
            $resp = recaptcha_check_answer (CAPTCHA_PRIVATE_KEY,
                $_SERVER["REMOTE_ADDR"],
                $data["recaptcha_challenge_field"],
                $data["recaptcha_response_field"]);

            if (!$resp->is_valid)
                $this->addError('Captcha', 'Captcha invalide');
        }
        else
            $this->addError('Captcha', 'Captcha invalide');

        return !$this->hasError();
    }
}
