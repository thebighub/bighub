<?php

namespace Core\Database;

use PDO;
/**
 * The Big Hub
 * @authors Matth Schmit (@MatthSchmit), Tim Chapelle (@timchapelle)
 * https://github.com/thebighub
 *
 * Classe de connexion à la db + requêtes
 *
 */
class MySQLDatabase {

    private $dbhost;
    private $dbname;
    private $dbuser;
    private $dbpass;
    private $pdo;

    public function __construct($dbhost, $dbname, $dbuser, $dbpass) {
        $this->dbhost = $dbhost;
        $this->dbname = $dbname;
        $this->dbuser = $dbuser;
        $this->dbpass = $dbpass;
    }

    public function getPDO() {
        if ($this->pdo === null) {
            $pdo = new PDO("mysql:host=$this->dbhost;dbname=$this->dbname", $this->dbuser, $this->dbpass, [PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8']);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->pdo = $pdo;
        }
        return $this->pdo;
    }

    public function requete($sql, $classe = null, $one = false) {
        $req = $this->getPDO()->query($sql);
        if (
                strpos($sql, 'INSERT') === 0 ||
                strpos($sql, 'UPDATE') === 0 ||
                strpos($sql, 'DELETE') === 0
        ) {
            return $req;
        }
        if ($classe === null) {
            $req->setFetchMode(PDO::FETCH_OBJ);
        } else {
            $req->setFetchMode(PDO::FETCH_CLASS, $classe);
        }
        if ($one) {
            $data = $req->fetch();
        } else {
            $data = $req->fetchAll();
        }

        return $data;
    }

    public function prepare($sql, $params, $classe = null, $one = false) {
        $req = $this->getPDO()->prepare($sql);
        $res = $req->execute($params);
        if (
                strpos($sql, 'INSERT') === 0 ||
                strpos($sql, 'UPDATE') === 0 ||
                strpos($sql, 'DELETE') === 0
        ) {
            return $res;
        }
        if ($classe === null) {
            $req->setFetchMode(PDO::FETCH_OBJ);
        } else {
            $req->setFetchMode(PDO::FETCH_CLASS, $classe);
        }
        if ($one) {
            $data = $req->fetch();
        } else {
            $data = $req->fetchAll();
        }
        return $data;
    }

    public function lastInsertId() {
        return $this->getPDO()->lastInsertId();
    }

}
