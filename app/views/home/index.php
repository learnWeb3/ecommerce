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

<section class="py-4 teaser-container">

    <h2 class="ml-4">Nouveautées</h2>

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


<div class="row divide-xl-2 divide-lg-4 divide-md-4 divide-sm-2 divide-xs-1">

    <div class="col">
        <h1>Titre h1</h1>
    </div>
    <div class="col">
        <h2>Titre h2</h2>
    </div>
    <div class="col">
        <h3>Titre h3</h3>
    </div>
    <div class="col">
        <h4>Titre h4</h4>
        <div class="form-group">
            <label for="">text here :</label>
            <select name="" id="">
                <option value="">aaa</option>
                <option value="">vvvv</option>
                <option value="">jjjj</option>
                <option value="">mmm</option>
            </select>
        </div>
    </div>

    <div class="col">
        <p>Lorem, ipsum dolor sit amet consectetur adipisicing elit. Tempore natus repudiandae molestiae sit ad voluptatum asperiores libero eligendi. Odio dignissimos sed debitis. Eius dolorum omnis nam voluptates magnam aspernatur corrupti.</p>
    </div>
    <div class="col">
        <div class="form-group">
            <label for="">label for input text</label>
            <input type="text">
        </div>
    </div>
    <div class="col"><button class="btn btn-lg btn-success">valider</button></div>
    <div class="col"><button class="btn btn-lg btn-danger">valider</button></div>

</div>


<script>
    $('.jumbotron').mouseenter(function() {
        $('.jumbotron video').animate({
            'opacity': 100
        }, "slow", "linear");
    });

    $('.jumbotron').mouseleave(function() {
        $('.jumbotron video').animate({
            'opacity': 0
        }, "slow", "linear");
    })


    $('.chevron-right').click(function() {
        var scrollLeft = $('.teaser-container .row-autoflow').scrollLeft();
        $(this).siblings('.row-autoflow').scrollLeft(scrollLeft + 50);
    });

    $('.chevron-left').click(function() {
        var scrollLeft = $('.teaser-container .row-autoflow').scrollLeft();
        $(this).siblings('.row-autoflow').scrollLeft(scrollLeft - 50);
    });
</script>