<?php

set_include_path(
    get_include_path() . PATH_SEPARATOR .
    '../libraries/' . PATH_SEPARATOR .
    '../views/' . PATH_SEPARATOR .
    '../'
);

require_once '../config.php';
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
* Db
*/
$db = new Quokka\Database\PDO('mysql:dbname=' . DB_NAME . ';host:localhost', DB_USER, DB_PSWD);
$db->setMapperNamespace('Application\\Model');
$application->addResource('db', $db);

/**
 * Auth
 */
$auth = new Quokka\Auth\Auth($db->getMapper('user'));
$application->addResource('auth', $auth);

/**
 * Plugins
 */
$application->addPlugin(new Application\Plugin\AuthPlugin());

/**
 * Routing
 */
$application->getRouter()->addRule('a', '/$', NULL, 'page', 'index');
$application->getRouter()->addRule('b', '/stands$', NULL, 'page', 'stand');
$application->getRouter()->addRule('c', '/contact$', NULL, 'page', 'contact');
$application->getRouter()->addRule('d', '/login$', NULL, 'account', 'login');
$application->getRouter()->addRule('e', '/logout$', NULL, 'account', 'logout');
$application->getRouter()->addRule('f', '/register$', NULL, 'account', 'register');
$application->getRouter()->addRule('g', '/register-success$', NULL, 'account', 'registersuccess');
$application->getRouter()->addRule('h', '/activate-account$', NULL, 'account', 'activateaccount');
$application->getRouter()->addRule('i', '/account$', NULL, 'account', 'index');

/**
 * Layout
 */
$layout = new Quokka\Mvc\View\View('layout.phtml');
$application->setLayout($layout);

/**
 * Let's goooooo !
 */
$application->run();
