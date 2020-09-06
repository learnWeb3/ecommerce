<div id="shopping-cart-menu" class="closed">

    <ul>
        <li class="menu-close"><img src="<?php echo ABSOLUTE_ASSET_PATH . "/icons/navigation/close.svg" ?>" alt="logo icon"></li>
    </ul>

    <div class="container p-4">

        <h2 class="article-number">Mon panier (<?php echo $basket->getBasketItemNumber() ?> articles)</h2>

        <div class="container-block" style="max-height:50%">

            <?php if ($basket->notEmpty()) : ?>

                <?php foreach ($basket_products as $basket_product) : ?>

                    <?php require 'partials/basket_item/basket_item_product.php' ?>

                <?php endforeach; ?>

            <?php endif; ?>
        </div>

        <div class="w-100" id="basket-price-zone" style="display:<?php echo $basket->getPriceZoneDisplay() ?>">
            <h2>Total:</h2>
            <hr class="light my-2">
            <h3 id="basket-total-HT">Sous-total (HT): <?php echo $basket->getTotalHT() ?> &euro;</h3>
            <h3>Livraison:</h3>
            <hr class="light my-2">
            <h2 id="basket-total-TTC">Total (TVA incluse): <?php echo $basket->getTotalTTC() ?> &euro;</h2>


            <buttton class="btn btn-lg btn-success my-4" id="stripe-checkout">Payer</buttton>
        </div>




        <?php if ($basket->Empty()) : ?>
            <img src="<?php echo ABSOLUTE_ASSET_PATH . "/icons/illustration/empty-basket.svg"
                        ?>" alt="empty basket illustration" id="empty-basket">

            <a href="" class="btn btn-lg btn-success my-2" id="see-product">Les produits </a>
        <?php endif; ?>

    </div>



</div>


<script>
    // CALLING AJAX FUNTION TO FETCH RESULT OF STRIPE SCRIPT
    const stripeSecret = "<?php echo STRIPE_PUBLISHABLE_KEY ?>";
    const appStripe = new AppStripe();
    appStripe.checkout("#stripe-checkout");
</script>