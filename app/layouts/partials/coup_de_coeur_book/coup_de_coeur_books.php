<?php if (!empty($coup_de_coeur_books)) : ?>


<section>
    <h2 class="ml-4"><a href="<?php echo REDIRECT_BASE_URL."controller=recommendation&method=index&book=coup_de_coeur"?>">Les Découvertes</a></h2>
    <div class="row divide-xl-4 divide-lg-2 divide-md-2 divide-sm-1 divide-xs-1">
        <?php foreach ($coup_de_coeur_books as $index => $coup_de_coeur_book) : ?>
            <div class="col align-items-center">
                <div class="card-product flex justify-content-evenly">

                    <div class="w-100 d-flex align-items-center flex-column">
                        <img src="<?php echo $coup_de_coeur_book['book']->getImagePath() ?>" class="w-100" alt="cover">
                        <blockquote class="my-2"><?php echo $coup_de_coeur_book['coup_de_coeur_books_comment']?></blockquote>
                    </div>

                    <div class="w-100">
                        <p class="price text-center"><?php echo $coup_de_coeur_book['book']->getPrice() ?> &euro;</p>

                        <form action="<?php echo REDIRECT_BASE_URL . "controller=basketitem&method=create" ?>" method="post" class="form-buy d-flex justify-content-center">

                            <input type="hidden" name="book_id" value="<?php echo $coup_de_coeur_book['book']->getId() ?>">

                            <button type="submit"><img src="<?php echo ABSOLUTE_ASSET_PATH . "/\icons\action\shopping_cart.svg" ?>" alt="basket icon"></button>

                        </form>
                    </div>

                </div>
            </div>
            <div class="col justify-content-evenly">
                <h2> <a href="<?php echo REDIRECT_BASE_URL."controller=book&method=show&id=".$coup_de_coeur_book['book']->getId()?>"><?php echo $coup_de_coeur_book["book"]->getTitle() ?></a></h2>

                <h3>Auteur:<?php echo $coup_de_coeur_book["book"]->getAuthor() ?></h3>
                <h3>Collection:<?php echo $coup_de_coeur_book["book"]->getCollection() ?></h3>
                <p> <?php echo $coup_de_coeur_book["book"]->getDescription() ?></p>
            </div>
        <?php endforeach; ?>
    </div>
</section>



<?php endif; ?>