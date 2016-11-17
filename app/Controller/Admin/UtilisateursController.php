<?php

namespace App\Controller\Admin;

use App;
use Core\HTML\BootstrapForm;

/**
 * The Big Hub
 * @authors Matth Schmit (@MatthSchmit), Tim Chapelle (@timchapelle)
 * https://github.com/thebighub
 *
 * Contrôleur des users, côté admin
 */
class UtilisateursController extends AppController {

    public function __construct() {
        parent::__construct();
        $app = App::getInstance();

        $this->loadModele('Utilisateur');
    }

    public function index() {
        $utilisateurs = $this->Utilisateur->all();
        $this->affichertwig('admin/utilisateurs/index', [
            'utilisateurs' => $utilisateurs
        ]);
    }

    /**
     * Ajouter un utilisateur
     */
    public function add() {
        $erreurs = [];
        if (!empty($_POST)) {

            if (!empty(trim($_POST["nom"])) && !empty(trim($_POST["prenom"])) && !empty(trim($_POST["mail"])) && !empty(trim($_POST["login"])) && !empty(trim($_POST["password"])) && !empty(trim($_POST["password2"]))
            ) {
                $nom = filter_input(INPUT_POST, 'nom', FILTER_SANITIZE_STRING);
                $prenom = filter_input(INPUT_POST, 'prenom', FILTER_SANITIZE_STRING);
                $mail = filter_input(INPUT_POST, 'mail', FILTER_SANITIZE_EMAIL);
                $login = filter_input(INPUT_POST, 'login', FILTER_SANITIZE_STRING);
                $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);
                $password2 = filter_input(INPUT_POST, 'password2', FILTER_SANITIZE_STRING);
                if ($password === $password2) {
                    $resultat = $this->Utilisateur->create([
                        'nom' => $nom,
                        'prenom' => $prenom,
                        'login' => $login,
                        'mail' => $mail,
                        'password' => md5($password)
                    ]);

                    if ($resultat) {
                        return $this->index();
                    }
                } else {
                    $erreurs[] = "Les mots de passe ne correspondent pas";
                }
            } else {
                $erreurs[] = "Tous les champs sont obligatoires";
            }
        }
        $form = new BootstrapForm($_POST);
        $this->loadModele('Groupe');
        $groupes = $this->Groupe->liste('id', 'nom');
        $titre = 'Ajouter un utilisateur';
        $this->affichertwig('admin/utilisateurs/edit', [
            'form' => $form,
            'groupes' => $groupes,
            'titre' => $titre,
            'erreurs' => $erreurs
        ]);
    }

    /**
     * Modifier un utilisateur
     */
    public function edit() {

        $this->loadModele('Utilisateur');
        $this->loadModele('Groupe');

        if (!empty($_POST)) {
            $resultat = $this->Utilisateur->update($_GET["id"], [
                'nom' => $_POST["nom"],
                'prenom' => $_POST["prenom"],
                'login' => $_POST["login"],
                'mail' => $_POST["mail"],
                'groupe_id' => $_POST["groupe_id"],
                'password' => md5($_POST["password"])
            ]);
            if ($resultat) {
                return $this->index();
            }
        }

        $utilisateur = $this->Utilisateur->find($_GET["id"]);
        $groupes = $this->Groupe->liste('id', 'nom');

        if (!$utilisateur) {
            $this->notFound();
        }
        $form = new BootstrapForm($utilisateur);

        $titre = 'Modifier un utilisateur';
        $this->affichertwig('admin/utilisateurs/edit', [
            'utilisateur' => $utilisateur,
            'groupes' => $groupes,
            'form' => $form,
            'titre' => $titre
        ]);
    }

    /**
     * Supprimer un utilisateur 
     */
    public function delete() {
        if (!empty($_POST)) {
            $resultat = $this->Utilisateur->delete($_POST["id"]);
            if ($resultat) {
                return $this->index();
            }
        }
    }

}
