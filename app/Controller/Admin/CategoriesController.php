<?php

namespace App\Controller\Admin;

use App;
use App\Controller\Admin\AppController;
use Core\HTML\BootstrapForm;

/**
 * The Big Hub
 * @authors Matth Schmit (@MatthSchmit), Tim Chapelle (@timchapelle)
 * https://github.com/thebighub
 *
 * Contrôleur des catégories, côté admin
 */
class CategoriesController extends AppController {

    public function __construct() {
        parent::__construct();
        $this->loadModele('Categorie');
    }

    public function index() {
        $categories = $this->Categorie->all();
        $this->affichertwig('admin/categories/index', [
            'categories' => $categories
        ]);
    }

    /**
     * Ajouter un article
     */
    public function add() {
        
        $this->loadModele('Categorie');
        if (!empty($_POST)) {
            $resultat = $this->Categorie->create([
                'titre' => $_POST["titre"],
            ]);

            if ($resultat) {
                return $this->index();
            }
        }
        $form = new BootstrapForm($_POST);
        $titre = 'Créer une catégorie';
        $this->affichertwig('admin/categories/edit', [
            'form' => $form,
            'titre' => $titre
        ]);
    }

    /**
     * Modifier un article
     */
    public function edit() {

        $this->loadModele('Categorie');

        if (!empty($_POST)) {
            $resultat = $this->Categorie->update($_GET["id"], [
                'titre' => $_POST["titre"]
            ]);
            if ($resultat) {
                return $this->index();
            }
        }
        $categorie = $this->Categorie->find($_GET["id"]);
        $form = new BootstrapForm($categorie);
        $titre = 'Modifier une catégorie';
        $this->afficher('admin.categories.edit', compact('form', 'titre'));
    }

    /**
     * Supprimer un article 
     */
    public function delete() {
        $this->loadModele('Categorie');

        if (!empty($_POST)) {
            $resultat = $this->Categorie->delete($_POST["id"]);
            if ($resultat) {
                return $this->index();
            }
        }
    }

}
