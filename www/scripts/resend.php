<?php

set_include_path(
    get_include_path() . PATH_SEPARATOR .
    '../libraries/' . PATH_SEPARATOR .
    '../'
);

require_once '../config.php';
require_once 'Quokka/Loader/Autoloader.php';

/**
 * Autoloading
 */
$autoload = new Quokka\Loader\Autoloader();
$autoload->addNamespace('Quokka', 'Quokka');
$autoload->addNamespace('Application\\Model', 'models');
$autoload->register();

/**
* Db
*/
$db = new Quokka\Database\PDO('mysql:dbname=' . DB_NAME . ';host:' . DB_HOST . '', DB_USER, DB_PSWD);
$db->setMapperNamespace('Application\\Model');

/**
 * Main
 */
if ($argc != 2) {

    echo "Usage : php resend.php email\n";
    exit();
}

$userMapper = $db->getMapper('user');

$user = $userMapper->fetchOneByEmail($argv[1]);
if ($user == false) {

    echo "Tu es perdu, l'utilisateur n'existe pas\n";
    exit();
}
else if ($user->getActive() == 1) {

    echo "Le compte est deja active connard !\n";
    exit();
}
else {

    $headers = 'From: no-reply@datlan.eu' . "\r\n" .
               'Reply-To: no-reply@datlan.eu' . "\r\n" .
               'Content-type: text/html; charset=iso-8859-1' . "\r\n" .
               'X-Mailer: PHP/' . phpversion();

    mail($user->getEmail(), 'Datlan - Activation de votre compte',
        "<p><a href='http://www.datlan.eu/activate-account?key=" . $user->getKey() . "'>Lien d'activation de votre compte</a></p>",
        $headers
    );
    echo "L'email a bien ete envoye a " . $user->getEmail() . "\n";
}
