class Alert
{
    static getAlerts(results,resultContainer) {
        const alertTemplate = (
            `<div id='alert' class='${results.type}'>
                <img src='/app/assets/icons/navigation/close.svg' alt='' id='close'>
             </div>`).trim();

        $(resultContainer).append(alertTemplate);
        let alert = $("#alert");
        results.message.forEach(element => {
            alert.append("<p>" + element + "</p>")
        });
    }

    
    static dismissAlerts() {
        if ($("#alert").length > 0) { $("#alert #close").click(function () { $("#alert").remove() }); }
    }

    static removeAlerts()
    {
        if ($("#alert").length > 0) {$("#alert").remove()}
    }
}