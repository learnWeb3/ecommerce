<section class="container bg-primary-circle-circle" id="index-product-container" style="min-height:100vh;">


    <div class="flex justify-content-center" style="margin-top:5rem;padding:4rem">
        <?php if (!empty($books)): ?>
        <?php foreach ($books as $book) : ?>
            <?php require LAYOUT_PATH . '/partials/product_card/product_card.php' ?>
        <?php endforeach; ?>
        <?php else:?>
            <h2>Pas de resultat pour votre recherche</h2>
        <?php endif;?>
    </div>
        
    <?php if (!empty($books)): ?>
    <ul id="pagination">
        <li>
            <form action="<?php echo REDIRECT_BASE_URL."controller=book&method=index".$search_filters?>" method="POST">
                <input type="hidden" name="previous_page">
                <input type="hidden" name="start" value="<?php echo $start?>">
                <button type="submit" class="btn btn-lg btn-primary" id="previous"><img src="<?php echo ABSOLUTE_ASSET_PATH."/icons/action/chevron_left_white.svg"?>" alt="icon right page"></button>
            </form>
        </li>
        <li>
            <form action="<?php echo REDIRECT_BASE_URL."controller=book&method=index".$search_filters?>" method="POST">
                <input type="hidden" name="next_page">
                <input type="hidden" name="start" value="<?php echo $start?>">
                <button type="submit" class="btn btn-lg btn-primary" id="next"><img src="<?php echo ABSOLUTE_ASSET_PATH."/icons/action/chevron_right_white.svg"?>" alt="icon left page"></button>
            </form>
        </li>
    </ul>

    <?php endif;?>
    
</section>