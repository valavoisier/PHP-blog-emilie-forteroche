<?php

class ArticleController extends AbstractController
{
    /**
     * Affiche la page d'accueil.
     * @return void
     */
    public function showHome(): void
    {
        $articleManager = new ArticleManager();
        $articles = $articleManager->getAllArticles();

        $this->renderView("Accueil", "home", ['articles' => $articles]);
    }

    /**
     * Affiche le détail d'un article.
     * @return void
     */
    public function showArticle(): void
    {     
        // Récupération de l'id de l'article demandé (avant incrémentation des vues).
        $id = Utils::request("id", -1);

        $articleManager = new ArticleManager();
/* -----------------------Nombre de vues--------------------------*/ 
        // Initialiser la liste des articles vus si elle n'existe pas
        if (!isset($_SESSION['viewed_articles'])) {
            $_SESSION['viewed_articles'] = [];
        }

        // Si l'article n'a pas encore été vu pendant cette session
        if (!in_array($id, $_SESSION['viewed_articles'])) {
            // Incrémenter le nombre de vues une fois pendant la session
            $articleManager->incrementViews($id);
            $_SESSION['viewed_articles'][] = $id;
        }
/* -----------------------fin Nombre de vues--------------------------*/ 
        $article = $articleManager->getArticleById($id);

        if (!$article) {
            throw new Exception("L'article demandé n'existe pas.");
        }


        $commentManager = new CommentManager();
        $comments = $commentManager->getAllCommentsByArticleId($id);
        
        //hérite de la méthode renderView() de AbstractController.php
        //approche suivant le principe DRY (Don't Repeat Yourself) et maintenant une structure cohérente pour l'affichage des vues.
        //pour afficher la vue detailArticle.php avec le layout detailArticle.php
        $this->renderView($article->getTitle(), "detailArticle", [
            'article' => $article,
            'comments' => $comments
        ]);
    }

    /**
     * Affiche le formulaire d'ajout d'un article.
     * @return void
     */
    public function addArticle(): void
    {
        $this->renderView("Ajouter un article", "addArticle", []);
    }

    /**
     * Affiche la page "à propos".
     * @return void
     */
    public function showApropos()
    {
        $this->renderView("A propos", "apropos", []);
    }
}
