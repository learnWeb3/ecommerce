function tabsDisplay()
{
    $("#my-order").click(function() {
        $("#tab-my-order").css({
            'display': 'grid'
        });
        $("#tab-my-account").css({
            'display': 'none'
        });
    });

    $("#my-account").click(function() {
        $("#tab-my-order").css({
            'display': 'none'
        });
        $("#tab-my-account").css({
            'display': 'grid'
        });
    });
}



$(document).ready(function(){
    tabsDisplay();
});