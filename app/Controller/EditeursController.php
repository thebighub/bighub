<?php

/**
 * The Big Hub
 * @authors Matth Schmit (@MatthSchmit), Tim Chapelle (@timchapelle)
 * https://github.com/thebighub
 *
 * Contrôleur de l'éditeur
 */

namespace App\Controller;

/**
 * Description of EditeursController
 *
 * @author Tim <tim at tchapelle.be>
 */
class EditeursController extends AppController {
    
    public function index() {
        return $this->afficher('editeur.index');
    }
    public function live() {
        return $this->afficher('editeur.editeurLive');
    }
    public function editLive() {
        return require('../app/vues/editeur/editeurLive.php');
    }
    public function ajax() {
        return require('../app/vues/editeur/editeurAjax.php');
    }
}
