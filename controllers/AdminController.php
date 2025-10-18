<?php

/**
 * Contrôleur de la partie admin.
 */

class AdminController extends AbstractController
{

    /**
     * Affiche la page d'administration.
     * @return void
     */
    public function showAdmin(): void
    {
        // On vérifie que l'utilisateur est connecté.
        $this->checkIfUserIsConnected();

        // On récupère les articles pour la vue.
        $articles = $this->getArticlesForView();
    /*-----------------renderView(); méthode-----------------*/
        // On affiche la page d'administration.
        $this->renderView("Administration", "admin", [
            'articles' => $articles
        ]);
    }
    /*------------------Monitoring------------------*/
    /**
     * Affiche la page de monitoring.
     * @return void
     */
    public function showDashboard(): void
    {
        // Vérification: Si l'utilisateur n'est pas connecté on renvoie vers le formulaire de connexion
        $this->checkIfUserIsConnected();
        // On récupère les paramètres de tri
        $sort = Utils::request("sort", "date"); // Colonne à trier (défaut: date)
        $order = Utils::request("order", "DESC");// Ordre ASC/DESC (défaut: DESC)

        $commentManager = new CommentManager();

        $articles = $this->getArticlesForView();
        // Pour chaque article, on ajoute le nombre de commentaires
        foreach ($articles as $article) {
            $nbComments = $commentManager->countCommentsByArticleId($article->getId());
            $article->setNbComments($nbComments);
        }
        // On récupère les articles triés
        // Tri des articles avec usort()
        usort($articles, function ($a, $b) use ($sort, $order) {
            switch ($sort) {
                case "views":
                    $valA = $a->getViews();
                    $valB = $b->getViews();
                    break;
                case "comments":
                    $valA = $a->getNbComments();
                    $valB = $b->getNbComments();
                    break;
                case "title":
                    $valA = strtolower($a->getTitle());
                    $valB = strtolower($b->getTitle());
                    break;               
                case "date":
                default:
                    $valA = $a->getDateCreation()->getTimestamp();
                    $valB = $b->getDateCreation()->getTimestamp();
                    break;
            }

            return $order === "ASC" ? $valA <=> $valB : $valB <=> $valA;
        });

        // Préparation des en-têtes
        $headers = [
            Utils::getSortHeader("Date", "date", $sort, $order),
            Utils::getSortHeader("Titre", "title", $sort, $order),
            Utils::getSortHeader("Vues", "views", $sort, $order),
            Utils::getSortHeader("Commentaires", "comments", $sort, $order)

        ];
        //hérite de la méthode renderView() de AbstractController.php
        //approche suivant le principe DRY (Don't Repeat Yourself) et maintenant une structure cohérente pour l'affichage des vues.
        //pour afficher la vue dashboard.php avec le layout dashboard.php
        $this->renderView("Tableau de bord", "dashboard", [
            'articles' => $articles,
            'headers' => $headers
        ]);
    }




    /**
     * Affichage du formulaire de connexion.
     * @return void
     */
    public function displayConnectionForm(): void
    {
        $this->renderView("Connexion", "connectionForm", []);
    }

    /**
     * Connexion de l'utilisateur.
     * @return void
     */
    public function connectUser(): void
    {
        // On récupère les données du formulaire.
        $login = Utils::request("login");
        $password = Utils::request("password");

        // On vérifie que les données sont valides.
        if (empty($login) || empty($password)) {
            throw new Exception("Tous les champs sont obligatoires. 1");
        }

        // On vérifie que l'utilisateur existe.
        $userManager = new UserManager();
        $user = $userManager->getUserByLogin($login);
        if (!$user) {
            throw new Exception("L'utilisateur demandé n'existe pas.");
        }

        // On vérifie que le mot de passe est correct.
        if (!password_verify($password, $user->getPassword())) {
            $hash = password_hash($password, PASSWORD_DEFAULT);
            throw new Exception("Le mot de passe est incorrect : $hash");
        }

        // On connecte l'utilisateur.
        $_SESSION['user'] = $user;
        $_SESSION['idUser'] = $user->getId();

        // On redirige vers la page d'administration.
        Utils::redirect("admin");
    }

    /**
     * Déconnexion de l'utilisateur.
     * @return void
     */
    public function disconnectUser(): void
    {
        // On déconnecte l'utilisateur.
        unset($_SESSION['user']);

        // On redirige vers la page d'accueil.
        Utils::redirect("home");
    }

    /**
     * Affichage du formulaire d'ajout d'un article.
     * @return void
     */
    public function showUpdateArticleForm(): void
    {
        $this->checkIfUserIsConnected();

        // On récupère l'id de l'article s'il existe.
        $id = Utils::request("id", -1);

        // On récupère l'article associé.
        $articleManager = new ArticleManager();
        $article = $articleManager->getArticleById($id);

        // Si l'article n'existe pas, on en crée un vide. 
        if (!$article) {
            $article = new Article();
        }

        // On affiche la page de modification de l'article.
        $this->renderView("Edition d'un article", "updateArticleForm", [
            'article' => $article
        ]);
    }

    /**
     * Ajout et modification d'un article. 
     * On sait si un article est ajouté car l'id vaut -1.
     * @return void
     */
    public function updateArticle(): void
    {
        $this->checkIfUserIsConnected();

        // On récupère les données du formulaire.
        $id = Utils::request("id", -1);
        $title = Utils::request("title");
        $content = Utils::request("content");

        // On vérifie que les données sont valides.
        if (empty($title) || empty($content)) {
            throw new Exception("Tous les champs sont obligatoires. 2");
        }

        // On crée l'objet Article.
        $article = new Article([
            'id' => $id, // Si l'id vaut -1, l'article sera ajouté. Sinon, il sera modifié.
            'title' => $title,
            'content' => $content,
            'id_user' => $_SESSION['idUser']
        ]);

        // On ajoute l'article.
        $articleManager = new ArticleManager();
        $articleManager->addOrUpdateArticle($article);

        // On redirige vers la page d'administration.
        Utils::redirect("admin");
    }

    /**
     * Suppression d'un article.
     * @return void
     */
    public function deleteArticle(): void
    {
        $this->checkIfUserIsConnected();

        $id = Utils::request("id", -1);

        // On supprime l'article.
        $articleManager = new ArticleManager();
        $articleManager->deleteArticle($id);
        Utils::setFlash("Article supprimé avec succès.");
        // On redirige vers la page d'administration.
        Utils::redirect("admin");
    }

    /**
     * Affichage de la page de modération des commentaires d'un article.
     * @return void
     */
    public function moderateArticle(): void
    {
        $this->checkIfUserIsConnected();

        $articleId = Utils::request("id");
        $articleManager = new ArticleManager();
        $commentManager = new CommentManager();

        $article = $articleManager->getArticleById($articleId);
        $comments = $commentManager->getAllCommentsByArticleId($articleId);


        $this->renderView("Modération des commentaires", "moderateArticle", [
            'article' => $article,
            'comments' => $comments
        ]);
       
    }

    /**
     * Suppression des commentaires sélectionnés.
     * @return void
     */
    public function deleteComments(): void
    {
        $this->checkIfUserIsConnected();

        $selectedIds = Utils::request("selectedComments", []);
        $articleId = Utils::request("articleId");

        if (!empty($selectedIds)) {
            $commentManager = new CommentManager();
            $count = 0;

            foreach ($selectedIds as $commentId) {
                $comment = $commentManager->getCommentById((int)$commentId);
                if ($comment && $commentManager->deleteComment($comment)) {
                    $count++;
                }
            }

            Utils::setFlash("$count commentaire(s) supprimé(s) avec succès.");
        } else {
            Utils::setFlash("Aucun commentaire sélectionné.");
        }

        Utils::redirect("moderateArticle", ['id' => $articleId]);
    }
}
