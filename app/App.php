<?php

use Core\Config;
use Core\Database\MySQLDatabase;

/**
 * Description of App
 */
class App {

    private $db_instance;
    private static $_instance;
    // Titre de la page, dynamique
    public $titre = 'The Big Hub';

    public static function load() {
        session_start();
        require ROOT . '/app/Autoloader.php';
        App\Autoloader::register();
        require ROOT . '/core/Autoloader.php';
        Core\Autoloader::register();
    }

    public static function getInstance() {
        if (is_null(self::$_instance)) {
            self::$_instance = new App();
        }
        return self::$_instance;
    }
    /**
     * Obtenir l'accès à 
     * @param string $name Le nom de la table
     * @return $className Une instance de la classe appelée
     */
    public function getTable($name) {
        $className = '\\App\\Tables\\' . ucfirst($name) . 'Table';
        return new $className($this->getDb());
    }

    /* Version 2 */

    public function getDb() {
        if (is_null($this->db_instance)) {
            $config = Config::getInstance(ROOT . '/config/config.php');
            $this->db_instance = new MySQLDatabase($config->get('dbHost'), $config->get('dbName'), $config->get('dbUser'), $config->get('dbPass'));
        }
        return $this->db_instance;
    }

    /* Version 1
      public static function getDb() {
      if (self::$database === null) {
      self::$database = new Database(self::DB_HOST, self::DB_NAME, self::DB_USER, self::DB_PASS);
      }
      return self::$database;
      } */

    public function getTitre() {
        return $this->titre;
    }

    public function setTitre($titre) {
        $this->titre .= ' | ' . $titre;
    }

}
