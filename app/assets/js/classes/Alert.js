class Alert
{
    static getAlerts(results) {
        $("#sign-container").append("<div id='alert' class='" + results.type + "'><img src='app/assets/icons/navigation/close.svg' alt='' id='close'></div>");
        let alert = $("#alert");
        results.message.forEach(element => {
            alert.append("<p>" + element + "</p>")
        });
    }
    
    
    static dismissAlerts() {
        if ($("#alert").length > 0) { $("#alert #close").click(function () { $("#alert").remove() }); }
    }
}