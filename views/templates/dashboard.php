<?php

/**
 * dashboard avec la liste des articles, 
 * tri des colonnes par ordre croissant et décroissant par: 
 * date de création, contenu, nombre de vues, nombre de commentaires 
 * accès à la visualisation et suppression des commentaires.
 */
?>

<h2>Monitoring</h2>
<p class="info-tri">Cliquez sur les en-têtes de colonnes pour trier les articles par ordre croissant et décroissant.</p>

<div class="monitoring">
    <table>
        <thead>
            <tr>
                <?php foreach ($headers as $header): ?>
                    <th>
                        <a href="index.php?action=dashboard&sort=<?= $header['column'] ?>&order=<?= $header['nextOrder'] ?>">
                            <?= $header['label'] ?> <?= $header['arrow'] ?>
                        </a>
                    </th>
                <?php endforeach; ?>
                <th>Gestion des commentaires</th>

            </tr>
        </thead>
        <tbody>

            <?php foreach ($articles as $article) { ?>

                <tr>
                    <td><?= date("d/m/Y H:i", $article->getDateCreation()->getTimestamp()) ?></td>
                    <td><?= htmlspecialchars($article->getTitle()) ?></td>                   
                    <td class="col-content"><?= $article->getViews() ?></td>
                    <td class="col-content"><?= $article->getNbComments() ?></td>

                    <td>
                        <a class="submit" href="index.php?action=moderateArticle&id=<?= $article->getId() ?>">Gérer</a>
                    </td>

                </tr>

            <?php } ?>

        </tbody>
    </table>
</div>

<a class="submit" href="index.php?action=admin">Édition des articles</a>