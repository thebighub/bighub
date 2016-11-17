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
 * Contrôleur des groupes, côté admin
 */
class GroupesController extends AppController {
    
    public function __construct() {
        parent::__construct();
        $this->loadModele('Groupe');
    }
    
    public function index() {
        $groupes = $this->Groupe->all();
        foreach ($groupes as $groupe) {
           $groupe->membresGroupe = App::getInstance()->getTable('Groupe')->getGroupMembers($groupe->id); 
        }
        $this->affichertwig('admin/groupes/index', [
            'groupes' => $groupes
        ]);
    }

    /**
     * Ajouter un groupe
     */
    public function add() {
        if (!empty($_POST)) {
            $resultat = $this->Groupe->create([
                'nom' => $_POST["nom"],
            ]);

            if ($resultat) {
                return $this->index();
            }
        }
        $form = new BootstrapForm($_POST);
        $titre = 'Ajouter un groupe';
        $this->affichertwig('admin/groupes/edit', [
            'form' => $form,
            'titre' => $titre
            ]);
    }

    /**
     * Modifier un groupe
     */
    public function edit() {

        if (!empty($_POST)) {
            $resultat = $this->Groupe->update($_GET["id"], [
                'nom' => $_POST["nom"],
            ]);
            if ($resultat) {
                return $this->index();
            }
        }

        $groupe = $this->Groupe->find($_GET["id"]);
        

        if (!$groupe) {
            $this->notFound();
        }
        $form = new BootstrapForm($groupe);
        $titre = 'Modifier un groupe';
        $this->affichertwig('admin/groupes/edit', [
            'groupe' => $groupe,
            'form'   => $form,
            'titre'  => $titre
            ]);
    }

    /**
     * Supprimer un groupe 
     */
    public function delete() {
        if (!empty($_POST)) {
            $resultat = $this->Groupe->delete($_POST["id"]);
            if ($resultat) {
                return $this->index();
            }
        }
    }
    
}
