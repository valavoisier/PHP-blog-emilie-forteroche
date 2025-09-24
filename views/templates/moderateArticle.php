<?php 
    /** 
     * page de modération des commentaires d'un article.. 
     */
?>
<?php if ($flash = Utils::getFlash()): ?>
    <div class="flash-message"><?= htmlspecialchars($flash) ?></div>
<?php endif; ?>
<h2>Commentaires de l’article : <?= Utils::format($article->getTitle()) ?></h2>

<form class="monitoring" method="post" action="index.php?action=deleteComments">
    <input type="hidden" name="articleId" value="<?= $article->getId() ?>">

    <table>
        <thead>
            <tr>
                <th>Pseudo</th>
                <th>Contenu</th>
                <th>Date</th>
                <th>Sélection</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($comments as $comment): ?>
                <tr>

                    <td><?= htmlspecialchars($comment->getPseudo()) ?></td>
                    <td><?= htmlspecialchars($comment->getContent()) ?></td>
                    <td><?= Utils::convertDateToFrenchFormat($comment->getDateCreation()) ?></td>
                    <td><input type="checkbox" name="selectedComments[]" value="<?= $comment->getId() ?>"></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <div class="actions">
        <button type="submit" class="submit" <?= Utils::askConfirmation("Confirmez-vous la suppression des commentaires sélectionnés ?") ?>>
            Supprimer la sélection
        </button>

    </div>
</form>
<h2>Monitoring: <a class="submit" href="index.php?action=dashboard">Gérer</a></h2>