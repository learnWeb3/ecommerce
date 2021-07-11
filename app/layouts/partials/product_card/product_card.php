<div class="card-product" id="<?php echo $book['book']->getId() ?>">

    <img src="<?php echo $book['book']->getImagePath() ?>" alt="" class="poster">

    <h3 class="book-title my-2"><a href="<?php echo REDIRECT_BASE_URL . "controller=book&method=show&id=" . $book['book']->getId() ?>"><?php echo $book['book']->getTitle() ?></a></h3>

    <p class="price"><?php echo $book['book']->getPrice() ?> &euro;</p>

    <form action="<?php echo REDIRECT_BASE_URL . "controller=basketitem&method=create" ?>" method="post" class="form-buy">

        <input type="hidden" name="book_id" value="<?php echo $book['book']->getId() ?>">

        <button type="submit"><img src="<?php echo ABSOLUTE_ASSET_PATH . "/\icons\action\shopping_cart.svg" ?>" alt="basket icon"></button>

    </form>

</div>