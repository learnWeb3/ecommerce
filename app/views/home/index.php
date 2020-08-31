<section class="jumbotron">
    <img alt="" src="<?php echo ABSOLUTE_ASSET_PATH . "/img/jumbotron-welcome.jpg" ?>">
    <video src="<?php echo ABSOLUTE_ASSET_PATH . "/video/commercial-book-shop.mp4" ?>" muted autoplay loop></video>
    <div class="overlay-light">

        <h1 class="title font-white">La Nuit des temps: librairie engagée de proximitée</h1>
    </div>
</section>



<section class="py-4 teaser-container">

    <h2 class="ml-4">Nouveautées</h2>

    <div class="row-autoflow">


        <?php foreach ($new_books as $new_book) : ?>
            <div class="col">
                <div class="card-product">

                 <img src="<?php echo $new_book['book']->getImagePath()?>" alt="">
                
                </div>

            </div>

        <?php endforeach; ?>



    </div>

    <img src="<?php echo ABSOLUTE_ASSET_PATH . "/icons/action/chevron_left.svg" ?>" alt="chevron left icon" class="chevron-left">
    <img src="<?php echo ABSOLUTE_ASSET_PATH . "/icons/action/chevron_right.svg" ?>" alt="chevron right icon" class="chevron-right">


</section>


<section>

    <h2 class="ml-4">Les coups de coeur</h2>
    <div class="row divide-xl-4 divide-lg-2 divide-md-2 divide-sm-1 divide-xs-1">

        <div class="col">
            <div class="card-product"></div>
        </div>
        <div class="col justify-content-evenly">
            <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Esse corporis voluptas maiores deleniti adipisci earum ducimus temporibus quisquam reiciendis veritatis laborum soluta iure consequuntur nihil distinctio quos impedit, ab suscipit?</p>
            <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Esse corporis voluptas maiores deleniti adipisci earum ducimus temporibus quisquam reiciendis veritatis laborum soluta iure consequuntur nihil distinctio quos impedit, ab suscipit?</p>
        </div>
        <div class="col">
            <div class="card-product"></div>
        </div>
        <div class="col justify-content-evenly">
            <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Esse corporis voluptas maiores deleniti adipisci earum ducimus temporibus quisquam reiciendis veritatis laborum soluta iure consequuntur nihil distinctio quos impedit, ab suscipit?</p>
            <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Esse corporis voluptas maiores deleniti adipisci earum ducimus temporibus quisquam reiciendis veritatis laborum soluta iure consequuntur nihil distinctio quos impedit, ab suscipit?</p>
        </div>


    </div>
</section>


<section>

    <h2 class="ml-4">Découvertes : </h2>
    <div class="row divide-xl-4 divide-lg-2 divide-md-2 divide-sm-1 divide-xs-1">

        <div class="col">
            <div class="card-product"></div>
        </div>
        <div class="col justify-content-evenly">
            <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Esse corporis voluptas maiores deleniti adipisci earum ducimus temporibus quisquam reiciendis veritatis laborum soluta iure consequuntur nihil distinctio quos impedit, ab suscipit?</p>
            <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Esse corporis voluptas maiores deleniti adipisci earum ducimus temporibus quisquam reiciendis veritatis laborum soluta iure consequuntur nihil distinctio quos impedit, ab suscipit?</p>
        </div>
        <div class="col">
            <div class="card-product"></div>
        </div>
        <div class="col justify-content-evenly">
            <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Esse corporis voluptas maiores deleniti adipisci earum ducimus temporibus quisquam reiciendis veritatis laborum soluta iure consequuntur nihil distinctio quos impedit, ab suscipit?</p>
            <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Esse corporis voluptas maiores deleniti adipisci earum ducimus temporibus quisquam reiciendis veritatis laborum soluta iure consequuntur nihil distinctio quos impedit, ab suscipit?</p>
        </div>


    </div>
</section>

<section class="py-4 teaser-container">

    <h2 class="ml-4">Les + populaires </h2>

    <div class="row-autoflow">

        <div class="col">
            <div class="card-product"></div>

        </div>

        <div class="col">
            <div class="card-product"></div>
        </div>
        <div class="col">
            <div class="card-product"></div>
        </div>
        <div class="col">
            <div class="card-product"></div>
        </div>


        <div class="col">
            <div class="card-product"></div>

        </div>

        <div class="col">
            <div class="card-product"></div>
        </div>
        <div class="col">
            <div class="card-product"></div>
        </div>
        <div class="col">
            <div class="card-product"></div>
        </div>

    </div>

    <img src="<?php echo ABSOLUTE_ASSET_PATH . "/icons/action/chevron_left.svg" ?>" alt="chevron left icon" class="chevron-left">
    <img src="<?php echo ABSOLUTE_ASSET_PATH . "/icons/action/chevron_right.svg" ?>" alt="chevron right icon" class="chevron-right">


</section>




<script src="<?php echo ABSOLUTE_ASSET_PATH ?>/js/jumbotron.js"></script>

<script src="<?php echo ABSOLUTE_ASSET_PATH ?>/js/row-autoflow.js"></script>

<script>
    $(document).ready(function() {

        var name = "ssssss";
        var url = "";
        var description = "ddddddd";
        var price = 200;
        var quantity = 1;
        var product = new Product(name, url, description, price, quantity)

        product.appendTemplate();
    })
</script>