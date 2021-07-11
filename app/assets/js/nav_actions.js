$(document).ready(function () {
    Autocomplete.search();
    Autocomplete.activateNavigation();

    $("#user_sign_action").click(function () {
        var toogle = $(this).parents('li').find("ul.toogle");
        if (toogle.attr('class') == "toogle d-none") {
            toogle.removeClass("d-none").addClass("d-flex");
        } else {
            toogle.removeClass("d-flex").addClass("d-none");
        }
    });

    Session.destroy();
});