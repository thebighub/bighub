<?php

/**
 * The Big Hub
 * @authors Matth Schmit (@MatthSchmit), Tim Chapelle (@timchapelle)
 * https://github.com/thebighub
 *
 * Contrôleur de l'application
 */
namespace App\Controller;

use Core\Controller\Controller;
use \App;

class AppController extends Controller {

    protected $template = 'defaut';

    public function __construct() {
        $this->viewPath = ROOT . '/app/Vues/';
    }

    protected function loadModele($modele) {
        $this->$modele = App::getInstance()->getTable($modele);
    }

    

}
