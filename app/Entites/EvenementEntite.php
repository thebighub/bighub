<?php

namespace App\Entites;
use App;
use Core\Entites\Entite;

/**
 * The Big Hub
 * @authors Matth Schmit (@MatthSchmit), Tim Chapelle (@timchapelle)
 * https://github.com/thebighub
 *
 * Entite événement
 */
class EvenementEntite extends Entite{
    
    protected $calendrier; 
    
    public function isParent() {
        return $this->parent;
    }
    
    public function isEnfant() {
        return $this->parent_id > 0;
    }
    public function getEnfants() {
        $nbenfants = App::getInstance()->getTable('Evenement')->nbEnfants($this->id);
        return $nbenfants;
        
    }
    
    
   
}
