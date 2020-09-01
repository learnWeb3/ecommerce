<div id="shopping-cart-menu" class="closed">

    <ul>
        <li class="menu-close"><img src="<?php echo ABSOLUTE_ASSET_PATH . "/icons/navigation/close.svg" ?>" alt="logo icon"></li>
    </ul>

    <div class="container p-4">

        <h2>Mon panier (<?php echo 0; ?> article)</h2>


        <?php if ($basket->notEmpty()) : ?>

            <div class="container-block">
                <?php foreach ($basket_products as $basket_product) : ?>


                    <div class="card-product" id="<?php echo  $basket_product->getBook()->getId() ?>">

                        <div class="col">
                            <img src="<?php echo  $basket_product->getBook()->getimagePath() ?>" alt="" class="product-presentation">
                        </div>
                        <div class="col">

                            <h4 class="product-title"> <a href="<?php echo REDIRECT_BASE_URL . "controller=book&method=show&id=" . $basket_product->getBook()->getId() ?>"><?php echo $basket_product->getBook()->getTitle() ?></a> </h4>
                            <h5 class="product-price"> <?php echo $basket_product->getBook()->getPrice() ?></h5>

                            <hr class="light my-2">

                            <form action="<?php echo REDIRECT_BASE_URL . "controller=basketitem&method=update" ?>" method="post">

                                <input type="hidden" name="book_id" value="<?php echo $basket_product->getBook()->getid() ?>">

                                <div class="form-group">

                                    <label for="<?php echo "book_quantity_" . $basket_product->getId() ?>">Quantitée :</label>

                                    <input type="number" class="book_quantity" name="book_quantity" id="<?php echo "book_quantity_" . $basket_product->getId() ?>" value="<?php echo $basket_product->getQuantity() ?>" min="1" required>
                                </div>

                            </form>
                        </div>

                        <form action="<?php echo REDIRECT_BASE_URL . "controller=basketitem&method=destroy" ?>" method="POST" class="delete-product">

                            <input type="hidden" name="book_id" value="<?php echo $basket_product->getBook()->getid() ?>">
                            <button type="submit"> <img src="http://localhost/ecommerce/app/assets/icons/navigation/close.svg" alt="remove product icon"></button>

                        </form>

                    </div>


                <?php endforeach; ?>
            </div>

        <?php else : ?>


            <img src="<?php echo ABSOLUTE_ASSET_PATH . "/icons/illustration/empty-basket.svg"
                        ?>" alt="empty basket illustration" id="empty-basket">

            <a href="" class="btn btn-lg btn-success my-2">Les produits </a>


        <?php endif; ?>


    </div>


</div>

<script>
    $('.book_quantity').keyup(function() {

        var form = $(this).closest('form');

        var quantityInput = form.find('.book_quantity')
        
        var quantityInputVal = quantityInput.val();

        if (quantityInputVal != "" && typeof(quantityInputVal) == "string") {
            $.ajax({
                url: "/ecommerce/index.php",
                method: "POST",
                data: "controller=basketitem&method=update&" + form.serialize() + "&remote=true",
                dataType: "JSON",
                success: function(result, status) {
                    quantityInput.val(result.quantity);
                },
                error: function(result, error, status) {
                    console.log(status);
                }
            });
        }

    });
</script>