$(document).ready(function() {
    // NAVBAR FIXED POSITION ON SCROLL DOWN
    $(window).scroll(function() {
        var scrollPos = $(this).scrollTop();
        var navHeight = $("nav").outerHeight();
        if (scrollPos > navHeight) {
            $("nav").addClass("fixed");
        } else {
            $("nav").removeClass("fixed");
        }

        if (scrollPos >= navHeight ) {
            $("nav").addClass('bg-white')
        } else {
            $("nav").removeClass('bg-white')
        }
    });

    // NAVBAR MENU OPEN AND CLOSE

    $("#menu-open img").click(function() {
        $("#menu").removeClass("closed").addClass("opened");
    });
    $("#menu .menu-close img").click(function() {
        $("#menu").removeClass("opened").addClass("closed");
    });

    // NAVBAR SHOPPING CART OPEN AND CLOSE

    $("#shopping-cart img").click(function() {
        $("#shopping-cart-menu").removeClass("closed").addClass("opened");
    });

    $("#shopping-cart-menu .menu-close img").click(function() {
        $("#shopping-cart-menu").removeClass("opened").addClass("closed");
    });

    $("#search-open img").click(function() {
        $("#search-menu").removeClass("closed").addClass("opened");
    });

    $("#search-menu .menu-close img").click(function() {
        $("#search-menu").removeClass("opened").addClass("closed");
    });

});