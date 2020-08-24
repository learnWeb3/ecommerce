<section class="jumbotron" id="welcome">

    <img src="<?php echo ABSOLUTE_ASSET_PATH . "/img/happy_reading.jpg" ?>" alt="">

    <video src="<?php echo ABSOLUTE_ASSET_PATH . "/video/commercial-book-shop.mp4" ?>" muted autoplay loop></video>

</section>


<section class="row divide-xl-1 divide-lg-1 divide-md-1 divide-sm-1 divide-xs-1">

    <div class="col">
        <h2> Les Nouveautées :</h2>


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

    // $(".carroussel .next").click(function() {
    //     $(this).siblings('ul').animate({
    //         transform: 'translate(-50%)'
    //     }, 1, function() {
    //         $(this).css({
    //             transform: 'unset'
    //         }).find("li:last").after($(this).find("li:first"));
    //     })
    // });

    // $(".carroussel .prev").click(function() {
    //     $(this).siblings('ul').animate({
    //         transform: 'translate(50%)'
    //     }, 1, function() {
    //         $(this).css({
    //             transform: 'unset'
    //         }).find("li:last").after($(this).find("li:first"));
    //     })
    // })
</script>