<section id="show-product-container" class="bg-primary-circle-circle">
    <div class="row divide-xl-2 divide-lg-2 divide-md-1 divide-sm-1 divide-xs-1 py-8">
        <div class="col p-4 justify-center-lower-justify-end">
            <div class="flex justify-content-between">
                <h1><?php echo $page_book->getTitle() ?></h1>
                <h2>Auteur: <?php echo $page_book->getAuthor() ?></h2>
            </div>

            <hr class="light my-2">

            <h3> <?php echo $page_book->getDescription() ?></h3>

            <hr class="light my-2">

            <ul class="show-details">
                <li>Collection: <?php echo $page_book->getCollection() ?></li>
                <li>Année publication: <?php echo $page_book->getPublicationYear() ?></li>
            </ul>

        </div>

        <div class="col justify-center-lower-justify-end p-4 align-items-center">

            <img src="<?php echo $page_book->getImagePath() ?>" alt="<?php echo $page_book->getTitle() ?> cover image" class="book-presentation-show">
            <form action="<?php echo REDIRECT_BASE_URL . "controller=basketitem&method=create" ?>" method="post" id="form-buy" class="my-2">

                <input type="hidden" name="book_id" value="<?php echo $page_book->getId() ?>">


                <div class="form-group">

                    <label for="<?php echo "book_quantity_" . $page_book->getId() ?>">Quantitée :</label>
                    <div class="number">
                        <input type="number" class="book_quantity" name="book_quantity" id="<?php echo "book_quantity_" . $page_book->getId() ?>" value="1" min="1" required>
                    </div>
                </div>

                <div class="form-group-inline">

                    <h3>Prix:</h5>
                        <h3><?php echo $page_book->getPrice() ?> &euro;</h5>

                </div>

                <button type="submit" class="mx-auto"><img src="<?php echo ABSOLUTE_ASSET_PATH . "/\icons\action\shopping_cart.svg" ?>" alt="basket icon"></button>

            </form>

        </div>

    </div>

</section>

<?php require_once LAYOUT_PATH."/partials/similar_products/similar_products.php" ?>


<div id="modal-image-zoom-open">
    <img src="<?php echo $page_book->getImagePath() ?>" alt="<?php echo $page_book->getTitle() ?> cover image" style="transform:scale(2)">
    <img src="<?php echo ABSOLUTE_ASSET_PATH . "/icons/navigation/close.svg" ?>" alt="close modal image presentation" class="close">
</div>



<!-- PAGE SPECIFIC SCRIPT -->

<script src="<?php echo ABSOLUTE_ASSET_PATH?>/js/show-product.js"></script>

<script src="<?php echo ABSOLUTE_ASSET_PATH ?>/js/row-autoflow.js"></script>