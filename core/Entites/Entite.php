<?php

namespace Core\Entites;

/**
 * The Big Hub
 * @authors Matth Schmit (@MatthSchmit), Tim Chapelle (@timchapelle)
 * https://github.com/thebighub
 *
 * Modèle des entités
 */
class Entite {

    /**
     * Méthode "magique" qui permet d'appeler la méthode get$cle() lorsqu'on affiche $this->$cle
     * @param string $cle
     * @return method
     */
    public function __get($cle) {
        $method = 'get' . ucfirst($cle);
        $this->$cle = $this->$method();
        return $this->$cle;
    }

}
