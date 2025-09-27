<?php
class AbstractController
{
    /**
     * Vérifie si l'utilisateur est connecté.
     * Si ce n'est pas le cas, redirige vers la page de connexion.
     * @return void
     */
    protected function checkIfUserIsConnected(): void
    {
        // Démarrage de la session si ce n’est pas déjà fait
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_SESSION['user'])) {
             Utils::redirect("connectionForm");
        }
    }

    /**
     * Méthode pour rendre une vue avec un layout spécifique.
     * @param string $viewName : le nom de la vue à rendre.
     * @param string $viewLayout : le layout à utiliser.
     * @param array $data : les données à passer à la vue.
     * @return void
     */
    protected function renderView(string $viewName, string $viewLayout, array $data = []): void
    {
        $view = new View($viewName);
        $view->render($viewLayout, $data);
    }
}