class Session {

    static create(targetedSelector) {

        $(targetedSelector).click(function () {

            $(targetedSelector).parent("form").submit(function (event) {

                event.preventDefault();

                $.ajax({
                    url: "/ecommerce/index.php",
                    method: "POST",
                    data: "controller=session&method=create&" + $(this).serialize() + "&remote=true",
                    dataType: "JSON",
                    success: function (results, status) {
                        if (results.hasOwnProperty("type")) {
                            if (results.type == "danger") {
                                if ($('#alert').length > 0) { $("#alert").remove(); }
                                Alert.getAlerts(results);
                            } else {
                                $("#sign-in").remove();
                                $("#sign-container").append("<h2 class='my-4'>Bon retour parmis nous !</h2><a href='http://localhost/ecommerce/index.php?controller=home&method=index' class='btn btn-success btn-lg'>La Boutique</a>");
                            }

                            Alert.dismissAlerts();
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
            data: "controller=session&method=destroy&" + $(this).serialize() + "&remote=true",
            dataType: "JSON",
            success: function (results, status) {
                console.log(results);
            },
            error: function (XhrObject, error, status) {

                console.log(error);
            }
        });
    }
}