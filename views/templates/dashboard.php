<?php

/**
 * Page de test du dashboard.
 */
?>

<h2>Monitoring</h2>

<div class="monitoring">
    <table>
        <thead>
            <tr>
                <th>Titre</th>
                <th>Contenu</th>
                <th>Vues</th>
                <th>Commentaires</th>
                <th>Date de publication</th>
                <th>Gestion des commentaires</th>
            </tr>
        </thead>
        <tbody>

            <?php foreach ($articles as $article) { ?>

                <tr>
                    <td><?= htmlspecialchars($article->getTitle()) ?></td>
                    <td><?= $article->getContent(200) ?></td>
                    <td><?= $article->getViews() ?></td>
                    <td><?= $article->getNbComments() ?></td>
                    <td><?= date("d/m/Y H:i", $article->getDateCreation()->getTimestamp()) ?></td>
                    <td>
                        <a class="submit" href="index.php?action=manageComments&id=<?= $article->getId() ?>">Gérer</a>
                    </td>
                </tr>

            <?php } ?>

        </tbody>
    </table>
</div>

<h2>Edition des articles: <a class="submit" href="index.php?action=admin">Gérer</a></h2>