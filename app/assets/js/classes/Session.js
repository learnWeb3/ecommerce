class Session {

    static create(targetedSelector, resultContainer, checkout = false) {

        $(targetedSelector).submit(function (event) {

            event.preventDefault();

            $.ajax({
                url: "index.php",
                method: "POST",
                data: "controller=session&method=create&" + $(this).serialize() + "&remote=true",
                dataType: "JSON",
                success: function (results, status) {
                    if (results.hasOwnProperty("type")) {
                        if (results.type == "danger") {
                            if ($('#alert').length > 0) { $("#alert").remove(); }
                            Alert.getAlerts(results, resultContainer);
                        } else {
                            Alert.removeAlerts();

                            $(targetedSelector).remove();
                            $("nav ul.toogle").html("<li><a href='http://localhost/ecommerce/index.php?controller=user&method=edit' id='edit'>Mon profil</a></li><li><a href='http://localhost/ecommerce/index.php?controller=session&method=destroy' id='sign-out'>Deconnexion</a></li>");
                            if (checkout) {
                                window.location.assign("index.php?controller=order&method=new&step=2");
                            } else {
                                var resultContainerContent = "<h2 class='my-4'>Bon retour parmis nous !</h2><a href='http://localhost/ecommerce/index.php?controller=home&method=index' class='btn btn-success btn-lg'>La Boutique</a>";
                                $(resultContainer).append(resultContainerContent);
                            }
                        }
                    }

                    Alert.dismissAlerts();
                },
                error: function (XhrObject, error, status) {
                    console.log(error);
                }
            });
        });

    }

    static destroy() {

        $("#sign-out").click(function (event) {

            event.preventDefault();

            $.ajax({
                url: "index.php",
                method: "POST",
                data: "controller=session&method=destroy&remote=true",
                dataType: "JSON",
                success: function (results, status) {

                    $('#sign-out').closest("ul").html("<li><a href='http://localhost/ecommerce/index.php?controller=session&method=new'>Connexion</a></li>" +
                        "<li><a href='http://localhost/ecommerce/index.php?controller=user&method=new'>Inscription</a></li>");

                },
                error: function (XhrObject, error, status) {
                    console.log(error);
                }
            });
        });

    }
}