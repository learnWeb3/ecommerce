<div class="card-product" id="<?php echo  $basket_product->getBook()->getId() ?>">

    <div class="col">
        <img src="<?php echo  $basket_product->getBook()->getimagePath() ?>" alt="" class="product-presentation">
    </div>
    <div class="col">

        <h4 class="product-title"> <a href="<?php echo REDIRECT_BASE_URL . "controller=book&method=show&id=" . $basket_product->getBook()->getId() ?>"><?php echo $basket_product->getBook()->getTitle() ?></a> </h4>

        <h5> <?php echo $basket_product->getBook()->getHtPrice()?> &euro; HT</h5>
        <h5 class="product-price"> <?php echo $basket_product->getBook()->getPrice() ?> &euro; TTC</h5>

        <hr class="light my-2">

        <form action="<?php echo REDIRECT_BASE_URL . "controller=basketitem&method=update" ?>" method="post">

            <input type="hidden" name="book_id" value="<?php echo $basket_product->getBook()->getid() ?>">

            <div class="form-group">

                <label for="<?php echo "book_quantity_" . $basket_product->getId() ?>">Quantitée :</label>
                <div class="number">
                    <input type="number" class="book_quantity" name="book_quantity" id="<?php echo "book_quantity_" . $basket_product->getId() ?>" value="<?php echo $basket_product->getQuantity() ?>" min="1" required>
                </div>
            </div>

        </form>
    </div>

    <form action="<?php echo REDIRECT_BASE_URL . "controller=basketitem&method=destroy" ?>" method="POST" class="delete-product">

        <input type="hidden" name="book_id" value="<?php echo $basket_product->getBook()->getid() ?>">
        <button type="submit"> <img src="http://localhost/ecommerce/app/assets/icons/navigation/close.svg" alt="remove product icon"></button>

    </form>

</div>
