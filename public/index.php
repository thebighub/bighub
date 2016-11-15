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



// Définition du dossier de base pour les url
define('ROOT', dirname(__DIR__));

// Autoload des classes
require ROOT . '/app/App.php';
App::load();

if (isset($_GET["p"])) {
    $page = $_GET["p"];
} else {
    $page = 'articles.index';
}

$page = explode('.', $page);
if ($page[0] == 'admin') {
    $controller = '\App\Controller\Admin\\' . ucfirst($page[1]) . 'Controller';
    $action = $page[2];
}
else {
    $controller = '\App\Controller\\' . ucfirst($page[0]) . 'Controller';
    $action = $page[1];
}

$controller = new $controller();
$controller->$action();
?>

