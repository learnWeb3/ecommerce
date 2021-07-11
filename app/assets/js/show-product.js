$(document).ready(function() {
    $(".book-presentation-show").mouseenter(function() {
        $("#modal-image-zoom-open").animate({
            "left": 0
        }), 500
    });

    $("#modal-image-zoom-open").click(function() {
        $(this).animate({
            "left": '-100%'
        }), 500
    });
});