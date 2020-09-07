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


<?php if (!empty($recommended_books)) : ?>
    <section>
        <h2 class="ml-4">Les coups de coeur</h2>
        <div class="row divide-xl-4 divide-lg-2 divide-md-2 divide-sm-1 divide-xs-1">
            <?php foreach ($recommended_books as $index => $recommended_book) : ?>
                <div class="col">
                    <div class="card-product"></div>
                </div>
                <div class="col justify-content-evenly">
                    <?php echo $recommended_book["book"]->getDescription() ?>
                </div>
            <?php endforeach; ?>
        </div>
    </section>

<?php endif; ?>

<?php if (!empty($coup_de_coeur_books)) : ?>

    <section>
        <h2 class="ml-4">Decouvertes</h2>
        <div class="row divide-xl-4 divide-lg-2 divide-md-2 divide-sm-1 divide-xs-1">
            <?php foreach ($coup_de_coeur_books as $index => $$coup_de_coeur_book) : ?>
                <div class="col">
                    <div class="card-product"></div>
                </div>
                <div class="col justify-content-evenly">
                    <?php echo $coup_de_coeur_book["book"]->getDescription() ?>
                </div>
            <?php endforeach; ?>
        </div>
    </section>

<?php endif; ?>

<?php if (!empty($best_sales_books)) : ?>
    <section class="py-4 teaser-container">

        <h2 class="ml-4">Les + populaires </h2>

        <div class="row-autoflow">

            <?php foreach ($best_sales_books as $best_sales_book) : ?>
                <div class="col">
                    <div class="card-product">

                        <img src="<?php echo $best_sales_book['book']->getImagePath() ?>" alt="" class="poster">

                        <h3 class="my-2"><a href=""><?php echo $best_sales_book['book']->getTitle() ?></a></h3>

                        <a href=""><?php echo $best_sales_book['book']->getPrice() ?> &euro;</a>

                    </div>

                </div>

            <?php endforeach; ?>


        </div>

        <img src="<?php echo ABSOLUTE_ASSET_PATH . "/icons/action/chevron_left.svg" ?>" alt="chevron left icon" class="chevron-left">
        <img src="<?php echo ABSOLUTE_ASSET_PATH . "/icons/action/chevron_right.svg" ?>" alt="chevron right icon" class="chevron-right">


    </section>

<?php endif; ?>




<script src="<?php echo ABSOLUTE_ASSET_PATH ?>/js/jumbotron.js"></script>

<script src="<?php echo ABSOLUTE_ASSET_PATH ?>/js/row-autoflow.js"></script>