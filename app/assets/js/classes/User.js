class User {
    constructor(email, password) {
        this.email = email;
        this.password = password;
    }

    static create(targetedSelector) {
        $(targetedSelector).click(function () {

            $(targetedSelector).parent("form").submit(function (event) {

                event.preventDefault();

                $.ajax({
                    url: "/ecommerce/index.php",
                    method: "POST",
                    data: "controller=user&method=create&" + $(this).serialize() + "&remote=true",
                    dataType: "JSON",
                    success: function (results, status) {
                        if (results.hasOwnProperty("type")) {
                            if (results.type == "danger") {
                                if ($('#alert').length > 0) { $("#alert").remove(); }
                                User.getAlerts(results);
                            } else {
                                $("#sign-in").remove();
                                $("#sign-container").append("<h2 class='my-4'>Bonjour et bienvenue parmis nous !</h2><a href='/index.php?controller=session&method=new' class='btn btn-success btn-lg'>Connexion</a>");
                                User.getAlerts(results);
                            }

                            User.dismissAlerts();
                        }
                    },
                    error: function (XhrObject, error, status) {

                        console.log(error);
                    }
                });
            })

        });

    }

    static destroy() {
        $.ajax({
            url: "/ecommerce/index.php",
            method: "POST",
            data: "controller=user&method=destroy&" + $(this).serialize() + "&remote=true",
            dataType: "JSON",
            success: function (results, status) {
                console.log(results);
            },
            error: function (XhrObject, error, status) {
                console.log(error);
            }
        });
    }

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