<section class="jumbotron" id="welcome">

    <img src="<?php echo ABSOLUTE_ASSET_PATH . "/img/book_choice.jpg" ?>" alt="">

    <img src="<?php echo ABSOLUTE_ASSET_PATH . "/img/happy_reading.jpg" ?>" alt="">

    <video src="<?php echo ABSOLUTE_ASSET_PATH . "/video/commercial-book-shop.mp4" ?>" muted autoplay loop></video>

    <div class="mask-img-1">
        <h1 class="font-white title">La Nuit des temps : <br>
            librairie engagée de proximitée</h1>
    </div>

    <div class="mask-menu-container">
        <ul class="w-100 flex justify-content-evenly">
            <li><a href="" class="link-product ">LIVRES</a></li>
            <li><a href="" class="link-product ">PRESSE</a></li>
        </ul>

        <ul class="w-100 flex justify-content-evenly">
            <li><a href="" class="link-product ">PAPETERIE</a></li>
            <li><a href="" class="link-product ">EVENEMENTS</a></li>
        </ul>
    </div>


</section>


<section class="row divide-xl-2 divide-lg-2 divide-md-2 divide-sm-1 divide-xs-1">

    <div class="col">
        <h2> Les Nouveautées :</h2>
        <div class="carroussel">
            <ul>
                <li><img src="https://lewebpedagogique.com/bibliorians/files/2015/03/Nouveaut%C3%A9s.jpg" alt=""></li>
                <li><img src="https://static.fnac-static.com/multimedia/Images/FD/Comete/130255/CCP_IMG_ORIGINAL/1703765.jpg" alt=""></li>
                <li><img src="https://encrypted-tbn0.gstatic.com/images?q=tbn%3AANd9GcQTA5g5nqFwdhZtj9w97ELKrKAuJ95O6T5GNQ&usqp=CAU" alt=""></li>
            </ul>
            <img src="<?php echo ABSOLUTE_ASSET_PATH . "/icons/action/chevron_left.svg" ?>" alt="" class="prev">
            <img src="<?php echo ABSOLUTE_ASSET_PATH . "/icons/action/chevron_right.svg" ?>" alt="" class="next">
        </div>

    </div>

    <div class="col">

        <h2>Les plus populaires :</h2>
        <div class="carroussel">
            <ul>
                <li><img src="" alt=""></li>
                <li><img src="" alt=""></li>
                <li><img src="" alt=""></li>
            </ul>

            <img src="<?php echo ABSOLUTE_ASSET_PATH . "/icons/action/chevron_left.svg" ?>" alt="" class="prev">
            <img src="<?php echo ABSOLUTE_ASSET_PATH . "/icons/action/chevron_right.svg" ?>" alt="" class="next">
        </div>

    </div>

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
    $('.mask-img-1').mouseenter(function() {
        $('#welcome video').animate({
            'opacity': 100
        }, "slow", "linear");
    });

    $('.mask-img-1').mouseleave(function() {
        $('#welcome video').animate({
            'opacity': 0
        }, "slow", "linear");
    })

    $(".carroussel .next").click(function() {
        $(this).siblings('ul').animate({
            transform: 'translate(-45vw)'
        }, 1, function() {
            $(this).css({
                marginLeft: 0
            }).find("li:last").after($(this).find("li:first"));
        })
    });

    $(".carroussel .prev").click(function() {
        $(this).siblings('ul').animate({
            transform: 'translate(45vw)'
        },1, function() {
            $(this).css({
                marginLeft: 0
            }).find("li:last").after($(this).find("li:first"));
        })
    })
</script>