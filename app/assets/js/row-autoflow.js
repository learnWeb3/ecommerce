$(document).ready(function() {

    $('.chevron-right').click(function() {
        var scrollLeft = $('.teaser-container .row-autoflow').scrollLeft();
        $(this).siblings('.row-autoflow').scrollLeft(scrollLeft + 50);
    });

    $('.chevron-left').click(function() {
        var scrollLeft = $('.teaser-container .row-autoflow').scrollLeft();
        $(this).siblings('.row-autoflow').scrollLeft(scrollLeft - 50);
    });

})