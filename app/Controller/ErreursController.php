<?php

namespace App\Controller;


/**
 * The Big Hub
 * @authors Matth Schmit (@MatthSchmit), Tim Chapelle (@timchapelle)
 * https://github.com/thebighub
 *
 * Contrôleur des erreurs
 */
class ErreursController extends AppController {

    public function erreur403() {
        $motif = 'Vous n\'êtes pas administrateur ! Bien essayé !';
        $this->afficher('erreurs.403', compact('motif'));
    }

    public function erreur404() {
        $motif = 'Cherche encore, en tout cas c\'est pas ici !';
        $this->afficher('erreurs.404', compact('motif'));
    }

}
