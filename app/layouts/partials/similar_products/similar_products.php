<?php if (!empty($similar_products)) : ?>
    <section class="py-4 teaser-container bg-primary-circle-circle">

        <h2 class="ml-4">Produits similaires</h2>

        <div class="row-autoflow">


            <?php foreach ($similar_products as $book) : ?>
                <div class="col">

                    <?php require LAYOUT_PATH . '/partials/product_card/product_card.php' ?>

                </div>

            <?php endforeach; ?>



        </div>

        <img src="<?php echo ABSOLUTE_ASSET_PATH . "/icons/action/chevron_left.svg" ?>" alt="chevron left icon" class="chevron-left">
        <img src="<?php echo ABSOLUTE_ASSET_PATH . "/icons/action/chevron_right.svg" ?>" alt="chevron right icon" class="chevron-right">


    </section>
<?php endif; ?>