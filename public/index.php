<?php

/**
 * The Big Hub
 * @authors Matth Schmit (@MatthSchmit), Tim Chapelle (@timchapelle)
 * https://github.com/thebighub
 * 
 * Point d'entrée du site (front controller)
 */
use App\Controller\ArticleController;
use App\Controller\UtilisateurController;
use \Twig_Environment;
use \Twig_Loader_Filesystem;

// Définition du dossier de base pour les url
define('ROOT', dirname(__DIR__));

// Autoload des classes
require ROOT . '/app/App.php';
App::load();

// Inclusion de Twig
include_once ROOT . '/vendor/twig/twig/lib/Twig/Autoloader.php';
Twig_Autoloader::register();

$loader = new Twig_Loader_Filesystem(ROOT . '/app/Vues'); // Dossier contenant les templates
$twig = new Twig_Environment($loader, array(
    'cache' => false,
    'debug' => true
        ));
$twig->addGlobal('session', $_SESSION);
$twig->addExtension(new Twig_Extension_Debug());
$twigFunction = new Twig_SimpleFunction('AppGetInstance', function() {
    App::getInstance();
});
$twig->addFunction($twigFunction);

// Gestion des GET

if (isset($_GET["p"])) {
    $page = $_GET["p"];
} else {
    $page = 'articles.index';
}

$page = explode('.', $page);
if ($page[0] == 'admin') {
    $controller = '\App\Controller\Admin\\' . ucfirst($page[1]) . 'Controller';
    $action = $page[2];
} else {
    $controller = '\App\Controller\\' . ucfirst($page[0]) . 'Controller';
    $action = $page[1];
}

$controller = new $controller();
$controller->$action();


