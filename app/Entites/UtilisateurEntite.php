<?php

namespace App\Entites;
use Core\Entites\Entite;
/**
 * The Big Hub
 * @authors Matth Schmit (@MatthSchmit), Tim Chapelle (@timchapelle)
 * https://github.com/thebighub
 *
 * Entite Utilisateur
 */
class UtilisateurEntite extends Entite {
    
    public function getUrl() {
        return 'index.php?p=utilisateurs.show&id=' . $this->id;
    }
    
    public function getAvatar() {
        if (is_null($this->avatar)) {
            return 'default_user.jpg';
        }
        return $this->avatar;
    }
    
    
}
