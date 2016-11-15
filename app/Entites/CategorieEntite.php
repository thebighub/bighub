<?php

namespace App\Entites;

use Core\Entites\Entite;

/**
 * The Big Hub
 * @authors Matth Schmit (@MatthSchmit), Tim Chapelle (@timchapelle)
 * https://github.com/thebighub
 *
 * Entite catégorie
 */
class CategorieEntite extends Entite {

    public function getUrl() {
        return 'index.php?p=articles.categories&id=' . $this->id;
    }

}
