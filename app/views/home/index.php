<section class="jumbotron">
    <img alt="" src="<?php echo ABSOLUTE_ASSET_PATH . "/img/jumbotron-welcome.jpg" ?>">
    <video src="<?php echo ABSOLUTE_ASSET_PATH . "/video/commercial-book-shop.mp4" ?>" muted autoplay loop></video>
    <div class="overlay-light">

        <h1 class="title font-white">La Nuit des temps: librairie engagée de proximitée</h1>
    </div>
</section>



<?php if (!empty($new_books)) : ?>
    <section class="py-4 teaser-container">

        <h2 class="ml-4">Nouveautées</h2>

        <div class="row-autoflow">


            <?php foreach ($new_books as $book) : ?>
                <div class="col">

                    <?php require LAYOUT_PATH . '/partials/product_card/product_card.php' ?>

                </div>

            <?php endforeach; ?>



        </div>

        <img src="<?php echo ABSOLUTE_ASSET_PATH . "/icons/action/chevron_left.svg" ?>" alt="chevron left icon" class="chevron-left">
        <img src="<?php echo ABSOLUTE_ASSET_PATH . "/icons/action/chevron_right.svg" ?>" alt="chevron right icon" class="chevron-right">


    </section>
<?php endif; ?>


<?php require_once LAYOUT_PATH . "/partials/coup_de_coeur_book/coup_de_coeur_books.php" ?>

<?php require_once LAYOUT_PATH . "/partials/recommended_book/recommended_books.php" ?>

<?php if (!empty($popular_books)) : ?>
    <section class="py-4 teaser-container">

        <h2 class="ml-4">Les + populaires </h2>

        <div class="row-autoflow">

            <?php foreach ($popular_books as $popular_book) : ?>
                <div class="col">
                    <div class="card-product">

                        <img src="<?php echo $popular_book['book']->getImagePath() ?>" alt="" class="poster">

                        <h3 class="my-2"><a href=""><?php echo $popular_book['book']->getTitle() ?></a></h3>

                        <a href=""><?php echo $popular_book['book']->getPrice() ?> &euro;</a>

                    </div>

                </div>

            <?php endforeach; ?>


        </div>

        <img src="<?php echo ABSOLUTE_ASSET_PATH . "/icons/action/chevron_left.svg" ?>" alt="chevron left icon" class="chevron-left">
        <img src="<?php echo ABSOLUTE_ASSET_PATH . "/icons/action/chevron_right.svg" ?>" alt="chevron right icon" class="chevron-right">


    </section>

<?php endif; ?>




<!-- PAGE SPECIFIC SCRIPT -->


<script src="<?php echo ABSOLUTE_ASSET_PATH ?>/js/jumbotron.js"></script>

<script src="<?php echo ABSOLUTE_ASSET_PATH ?>/js/row-autoflow.js"></script>