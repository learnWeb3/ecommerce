<section>
    <div class="row divide-xl-2 divide-lg-2 divide-md-1 divide-sm-1 divide-xs-1" style="min-height:100vh;">
        <div class="col justify-content-center p-4">
            <div class="flex">
                <h1><?php echo $book->getTitle() ?></h1>
                
                <h2 class="ml-5"><?php echo $book->getAuthor() ?></h2>
            </div>

            <hr class="light my-2">

            <h3> <?php echo $book->getDescription() ?></h3>



        </div>

        <div class="col justify-content-center p-4 align-items-center">

            <img src="<?php echo $book->getImagePath()?>" alt="<?php echo $book->getTitle()?> cover image" class="book-presentation-show">
            <form action="<?php echo REDIRECT_BASE_URL . "controller=basketitem&method=create" ?>" method="post" id="form-buy">

                <input type="hidden" name="book_id" value="<?php echo $book->getId() ?>">

                <div class="form-group">

                    <label for="<?php echo "book_quantity_" . $book->getId() ?>">Quantitée :</label>

                    <input type="number" class="book_quantity" name="book_quantity" id="<?php echo "book_quantity_" . $book->getId() ?>" value="1" min="1" required>
                </div>

                <button type="submit" class="btn btn-lg btn-success">valider</button>

            </form>

        </div>

    </div>

</section>


<div id="modal-image-zoom-open">
    <img src="<?php echo $book->getImagePath()?>" alt="<?php echo $book->getTitle()?> cover image" style="transform:scale(2)">
    <img src="<?php echo ABSOLUTE_ASSET_PATH."/icons/navigation/close.svg"?>" alt="close modal image presentation" class="close">
</div>

<script>

    $(".book-presentation-show").mouseenter(function(){
        $("#modal-image-zoom-open").animate(
            {
                "left":0
            }
        ),500
    });

    $("#modal-image-zoom-open").click(function(){
        $(this).animate(
            {
                "left":'-100%'
            }
        ),500
    });
</script>