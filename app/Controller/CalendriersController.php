<?php

namespace App\Controller;

use App;
use Core\Date\Date;
use Core\HTML\BootstrapForm;

/**
 * The Big Hub
 * @authors Matth Schmit (@MatthSchmit), Tim Chapelle (@timchapelle)
 * https://github.com/thebighub
 *
 * Contrôleur du calendrier 
 */
class CalendriersController extends AppController {

    public function __construct() {
        parent::__construct();
        if (!isset($_SESSION["auth"])) {
            $this->forbidden();
        }
        $this->loadModele('Calendrier');
        $this->loadModele('Evenement');
    }

    /**
     * Fonction index
     * @return Affiche une vue
     */
    public function index() {
        if (isset($_POST["choixCal"])) {
            $id = $_POST["choixCal"];
            $calendrier = $this->Calendrier->find($_SESSION["auth"], $id);
        } else if (isset($_GET["id"])) {
            $id = $_GET["id"];
            $calendrier = $this->Calendrier->find($_SESSION["auth"], $id);
        } else if (isset($_SESSION["lastCal"])) {
            $id = $_SESSION["lastCal"];
            $calendrier = $this->Calendrier->find($_SESSION["auth"], $id);
        } else {
            $calendrier = $this->Calendrier->find($_SESSION["auth"]);
        }
        $calendriers = $this->Calendrier->liste('id', 'titre', $_SESSION["auth"]);
        $evenements = $this->Evenement->all($calendrier->id);
        $form = new BootstrapForm($_POST);
        $formCal = new BootstrapForm($calendriers);
        $date = new Date();
        $year = isset($_GET["year"]) ? $_GET["year"] : date('Y');
        $dates = $date->all($year);
        return $this->affichertwig('calendrier/index', [
            'calendrier' => $calendrier,
            'calendriers' => $calendriers,
            'formCal' => $formCal, 
            'evenements' => $evenements,
            'form' => $form,
            'dates' => $dates,
            'year' => $year,
            'date' => $date
            ]);
    }

    public function add() {

        $resultat = $this->Calendrier->create([
            'titre' => filter_input(INPUT_POST, 'title', FILTER_SANITIZE_STRING),
            'user_id' => $_SESSION["auth"],
        ]);
        if ($resultat) {
            $_SESSION["lastCal"] = App::getInstance()->getDb()->lastInsertId();
            return $this->index();
        }
    }
    
    public function calendrierAjax() {
        return require($this->viewPath . 'calendrier/calendrierAjax.php');
    }

}
