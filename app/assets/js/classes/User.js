class User {
    constructor(email, password) {
        this.email = email;
        this.password = password;
    }

    static create(targetedSelector, targeted_password_input, targeted_password_confirmation_input) {

        $(targetedSelector).submit(function (event) {

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
                            Alert.getAlerts(results);
                        } else {
                            $("#sign-in").remove();
                            $("#sign-container").append("<h2 class='my-4'>La Nuit des Temps vous souhaite la bienvenue !</h2><a href='http://localhost/ecommerce/index.php?controller=session&method=new' class='btn btn-success btn-lg'>Connexion</a>");
                            Alert.getAlerts(results);
                        }

                        Alert.dismissAlerts();
                    }
                },
                error: function (XhrObject, error, status) {

                    console.log(error);
                }
            });
        })


        $(targeted_password_input).blur(function () {

            $.ajax({
                url: "/ecommerce/index.php",
                method: "POST",
                data: "controller=user&method=create" + "&user_password_check=" + $(this).val() + "&user_password_confirmation=" + $(targeted_password_confirmation_input).val() + "&remote=true",
                dataType: "JSON",
                success: function (results, status) {
                    if (results.hasOwnProperty("type")) {
                        if (results.type == "danger") {
                            if ($('#alert').length > 0) { $("#alert").remove(); }
                            Alert.getAlerts(results);
                        }
                        Alert.dismissAlerts();

                        console.log(results);
                    }
                },
                error: function (XhrObject, error, status) {

                    console.log(error);
                }
            });
        });

    }



}