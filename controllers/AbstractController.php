<?php
abstract class AbstractController
{
    /**
     * Vérifie si l'utilisateur est connecté.
     * Si ce n'est pas le cas, redirige vers la page de connexion.
     * @return void
     */
    protected function checkIfUserIsConnected(): void
    {
        if (!isset($_SESSION['user'])) {
             Utils::redirect("connectionForm");
        }
    }

    /**
     * Méthode pour rendre une vue avec un layout spécifique.
     * centralise la logique de rendu des vues.Evite la répétition de code dans les controllers enfants (AdminController.php et ArticleController.php))
     * @param string $viewName : le nom du fichier de vue à charger (à rendre).
     * @param string $viewLayout : : le layout (template principal) à utiliser
     * @param array $data : un tableau de données optionnel à passer à la vue
     * @return void
     */
    protected function renderView(string $viewName, string $viewLayout, array $data = []): void
    {
        $view = new View($viewName);
        // Appelle la méthode render de la classe View       
        // Passe le layout et les données à afficher
        $view->render($viewLayout, $data);
    }

    /**
     * Récupère tous les articles pour l'affichage dans les contrôleurs.
     * Méthode commune utilisée par plusieurs contrôleurs d'administration et dans l'affichage de la page d'accueil regroupant tous les articles.
     * transformation du nom de la méthode getAllArticles() en getArticlesForView() pour éviter confusion doublon de noms.
     * séparation des responsabilités : getArticlesForView() s'occupe uniquement de la récupération des articles pour la vue, tandis que les contrôleurs enfants gèrent la logique spécifique à chaque vue.
     * getArticles(): array s'occupe de l'accès aux données BDD via le modèle ArticleManager.php
     */
    protected function getArticlesForView(): array
    {
        $articleManager = new ArticleManager();
        return $articleManager->getAllArticles();
    }
}