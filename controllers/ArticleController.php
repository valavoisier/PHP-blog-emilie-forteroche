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
        // Démarrage de la session si ce n’est pas déjà fait
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        // Récupération de l'id de l'article demandé.
        $id = Utils::request("id", -1);

        $articleManager = new ArticleManager();

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
        $article = $articleManager->getArticleById($id);

        if (!$article) {
            throw new Exception("L'article demandé n'existe pas.");
        }


        $commentManager = new CommentManager();
        $comments = $commentManager->getAllCommentsByArticleId($id);

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
