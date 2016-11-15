<?php


namespace App\Controller\Admin;

use Core\Auth\DbAuth;
use \App;

/**
 * The Big Hub
 * @authors Matth Schmit (@MatthSchmit), Tim Chapelle (@timchapelle)
 * https://github.com/thebighub
 *
 * Contrôleur de l'application, côté admin
 */


class AppController extends App\Controller\AppController {

    public function __construct() {
        parent::__construct();
        $this->loadModele('Utilisateur');
        $this->currentUser = $this->Utilisateur->find($_SESSION["auth"]);
        if (!$this->currentUser->admin) {
            $this->admin = false;
            $this->forbidden();
        }
        else $this->admin = true;
    }

}
