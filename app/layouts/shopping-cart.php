<div id="shopping-cart-menu" class="closed">

    <ul>
        <li class="menu-close"><img src="<?php echo ABSOLUTE_ASSET_PATH . "/icons/navigation/close.svg" ?>" alt="logo icon"></li>
    </ul>

    <div class="container p-4">

        <h2>Mon panier (<?php echo 0; ?> article)</h2>

        <div class="container-block">

            <?php if ($basket->notEmpty()) : ?>

                <?php foreach ($basket_products as $basket_product) : ?>

                    <?php require_once 'partials/basket_item/basket_item_product.php' ?>

                <?php endforeach; ?>

            <?php endif; ?>
        </div>


        <div>
            <h2>Total:</h2>
            <hr class="light">
            <h3>Sous-total:  <?php echo $basket->getTotal()?></h3>
            <h3>Livraison:</h3>
            <hr class="light">
            <h2>Total (TVA incluse): </h2>
        </div>

       <buttton class="btn btn-lg btn-success">Payer</buttton>


        <?php if ($basket->Empty()) : ?>
            <img src="<?php echo ABSOLUTE_ASSET_PATH . "/icons/illustration/empty-basket.svg"
                        ?>" alt="empty basket illustration" id="empty-basket">

            <a href="" class="btn btn-lg btn-success my-2" id="see-product">Les produits </a>
        <?php endif; ?>

    </div>



</div>