<?php

namespace App\Entites;
use Core\Entites\Entite;
/**
 * The Big Hub
 * @authors Matth Schmit (@MatthSchmit), Tim Chapelle (@timchapelle)
 * https://github.com/thebighub
 *
 * Entite Groupe
 */
class GroupeEntite extends Entite {
    public function getUrl() {
        return 'index.php?p=admin.groupes.show&id=' . $this->id;
    }
    
    public function avatar($user) {
        if (is_null($user->avatar)) {
            return 'default_user.jpg';
        }
        return $user->avatar;
    }
    
}