<article style="padding-left:4rem;padding-right:4rem;padding-top:8rem" class="bg-primary-circle">

<?php if (isset($recommended_books)) : ?>

<?php require_once LAYOUT_PATH . "/partials/recommended_book/recommended_books.php" ?>

<?php elseif (isset($coup_de_coeur_books)) : ?>

    <?php require_once LAYOUT_PATH . "/partials/coup_de_coeur_book/coup_de_coeur_books.php" ?>

<?php endif; ?>
</article>