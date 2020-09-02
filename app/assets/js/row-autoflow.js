$(document).ready(function() {
    $('.chevron-right').click(function() {
        var scrollLeft = $('.teaser-container .row-autoflow').scrollLeft();
        $(this).siblings('.row-autoflow').scrollLeft(scrollLeft + 50);
        var book_most_recent_limit = 10;
        var book_most_recent_offset = 0;
        if ($(document).width() == scrollLeft) {
            $(this).siblings('.row-autoflow').scrollLeft(0)
            book_most_recent_offset += 10;
            $.ajax({
                url: "/ecommerce/index.php",
                method: "POST",
                dataType: "JSON",
                data: "book_most_recent_limit=" + book_most_recent_limit + "&book_most_recent_offset=" + book_most_recent_offset + "&remote=true",
                success: function(result, error, status) {

                },
                error: function(error, status) {


                }
            });
        }


    });

    $('.chevron-left').click(function() {
        var scrollLeft = $('.teaser-container .row-autoflow').scrollLeft();
        $(this).siblings('.row-autoflow').scrollLeft(scrollLeft - 50);
    });

})