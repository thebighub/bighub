<?php

namespace App\Entites;

use Core\Entites\Entite;

/**
 * The Big Hub
 * @authors Matth Schmit (@MatthSchmit), Tim Chapelle (@timchapelle)
 * https://github.com/thebighub
 *
 * Entite Message
 * 
 */
class MessageEntite extends Entite{
    
    public function getExtrait() {
        return substr($this->contenu,0,40);
    }
    
    
}
