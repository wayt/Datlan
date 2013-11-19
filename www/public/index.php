<?php

set_include_path(
    get_include_path() . PATH_SEPARATOR .
    '../libraries/' . PATH_SEPARATOR .
    '../views/' . PATH_SEPARATOR .
    '../'
);

require_once 'Quokka/Loader/Autoloader.php';

/**
 * Autoloading
 */
$autoload = new Quokka\Loader\Autoloader();
$autoload->addNamespace('Quokka', 'Quokka');
$autoload->addNamespace('Application\\Controller', 'controllers');
$autoload->addNamespace('Application\\Model', 'models');
$autoload->addNamespace('Application\\Plugin', 'plugins');
$autoload->addNamespace('Application\\Form', 'forms');
$autoload->register();

/**
 * Create an application !
 */
$application = new Quokka\Mvc\Application();

/**
 * Routing
 */
$application->getRouter()->addRule('home', '/$', NULL, 'home', 'index');
$application->getRouter()->addRule('stand', '/stands$', NULL, 'home', 'stand');
$application->getRouter()->addRule('contact', '/contact$', NULL, 'home', 'contact');
$application->getRouter()->addRule('login', '/login$', NULL, 'account', 'login');
$application->getRouter()->addRule('logout', '/logout$', NULL, 'account', 'logout');
$application->getRouter()->addRule('register', '/register$', NULL, 'account', 'register');

/**
 * Layout
 */
$layout = new Quokka\Mvc\View\View('layout.phtml');
$application->setLayout($layout);

/**
 * Let's goooooo !
 */
$application->run();
