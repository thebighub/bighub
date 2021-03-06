<?php

namespace App\Controller;

use Core\HTML\BootstrapForm;
use App;

/**
 * The Big Hub
 * @authors Matth Schmit (@MatthSchmit), Tim Chapelle (@timchapelle)
 * https://github.com/thebighub
 *
 * Contrôleur des messages
 */
class MessagesController extends AppController {

    public function __construct() {
        parent::__construct();
        $this->loadModele('Message');
        $this->loadModele('Utilisateur');
        if (empty($_SESSION["auth"])) {
            $this->forbidden();
        }
        $this->user = $_SESSION["auth"];
    }

    public function send() {
        if (!empty($_POST)) {
            $destinataires = explode(' ', trim($_POST["user_to"]));
            //$destinataire = $destinataires[0];
            for ($i = 0; $i < count($destinataires); $i++) {
                if ($destinataires[$i] != '') {


                    $this->Message->create([
                        'user_from' => $_POST["user_from"],
                        'user_to' => $this->Utilisateur->getIdByLogin($destinataires[$i]),
                        'sujet' => $_POST["sujet"],
                        'contenu' => $_POST["contenu"],
                        'proprio' => $_POST["user_from"]
                    ]);
                }
            }
            /*
              $resultat = $this->Message->create([
              'user_from' => $_POST["user_from"],
              'user_to' => $this->Utilisateur->getIdByLogin($destinataire),
              'sujet' => $_POST["sujet"],
              'contenu' => $_POST["contenu"],
              'proprio' => $_POST["user_from"]
              ]);

              if ($resultat) {
              return $this->index();
              }
             * 
             */
            return $this->index();
        }
        $form = new BootstrapForm($_POST);
        $utilisateurs = $this->Utilisateur->liste('id', 'login');
        $titre = 'Envoyer un message';
        $this->affichertwig('messages/edit', [
            'form' => $form,
            'utilisateurs' => $utilisateurs,
            'titre' => $titre
            ]);
    }

    public function edit() {
        
    }

    public function delete() {
        $resultat = $this->Message->delete($_POST["id"]);
        if ($resultat) {
            $this->index();
        }
    }

    public function index() {
        $user = $this->Utilisateur->find($this->user);
        $messages = $this->Message->all($this->user);
        App::getInstance()->setTitre('Boîte de réception');
        return $this->affichertwig('messages/index', [
            'messages' => $messages
            ]);
    }

    public function show() {
        $message = $this->Message->unique($_GET["id"]);
        if ($message->vu == 0) {
            $this->Message->update($_GET["id"], ["vu" => 1]);
        }
        return $this->affichertwig('messages/show', [
            "message" => $message
        ]);
    }

}
