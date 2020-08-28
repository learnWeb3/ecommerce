$(document).ready(function() {
    $('.jumbotron').mouseenter(function() {
        $('.jumbotron video').animate({
            'opacity': 100
        }, "slow", "linear");
    });

    $('.jumbotron').mouseleave(function() {
        $('.jumbotron video').animate({
            'opacity': 0
        }, "slow", "linear");
    });
});