<?php

namespace App\Controller;

use \App;

/**
 * The Big Hub
 * @authors Matth Schmit (@MatthSchmit), Tim Chapelle (@timchapelle)
 * https://github.com/thebighub
 *
 * Contrôleur des articles, public
 */
class ArticlesController extends AppController {

    public function __construct() {
        parent::__construct();
        $this->loadModele('Article');
        $this->loadModele('Categorie');
    }

    public function index() {
        $articles = $this->Article->last();
        $categories = $this->Categorie->all();
        // $this->afficher('articles.index', compact('articles', 'categories'));
        $this->affichertwig('articles/index', [
            "articles" => $articles,
            "categories" => $categories
        ]);
    }

    public function categories() {
        $categorie = $this->Categorie->find($_GET["id"]);

        if (!$categorie) {
            $this->notFound();
        }
        $articles = $this->Article->getByCategorie($_GET["id"]);
        if (!$articles) {
            $this->notFound();
        } else {
            $categories = $this->Categorie->all();
        }
        App::getInstance()->setTitre(($categorie->titre));
        $this->affichertwig('articles/categories', [
            'articles' => $articles,
            'categories' => $categories,
            'categorie' => $categorie]);
    }

    public function show() {
        $article = $this->Article->findWithCategory($_GET["id"]);
        if (!$article) {
            $this->notFound();
        } else {
            $cat = ($article->categorie === null) ? 'Catégorie non définie' : $article->categorie;
            App::getInstance()->setTitre(($article->titre));
        }
        $this->affichertwig('articles/show', [
            'article' => $article,
            'cat' => $cat
        ]);
    }

}
