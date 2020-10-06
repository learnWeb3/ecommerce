class User {
    constructor(email, password) {
        this.email = email;
        this.password = password;
    }

    static create(targetedSelector, targeted_password_input, targeted_password_confirmation_input, resultContainer, checkout = false) {

        $(targetedSelector).submit(function (event) {

            event.preventDefault();

            $.ajax({
                url: "index.php",
                method: "POST",
                data: "controller=user&method=create&" + $(this).serialize() + "&remote=true&checkout=" + checkout,
                dataType: "JSON",
                success: function (results, status) {
                    if (results.hasOwnProperty("type")) {
                        if (results.type == "danger") {
                            if ($('#alert').length > 0) { $("#alert").remove(); }
                        } else {
                            $("#sign-up").remove();
                            if (checkout) {
                                window.location.assign("index.php?controller=order&method=new&step=2")
                            } else {
                                const welcomeHeader = "<h2 class='my-4'>La Nuit des Temps vous souhaite la bienvenue !</h2><a href='index.php?controller=session&method=new' class='btn btn-success btn-lg'>Connexion</a>";
                                $(resultContainer).append(welcomeHeader);
                            }
                        }
                        Alert.getAlerts(results, resultContainer);
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
                url: "index.php",
                method: "POST",
                data: "controller=user&method=create" + "&user_password_check=" + $(this).val() + "&user_password_confirmation=" + $(targeted_password_confirmation_input).val() + "&remote=true",
                dataType: "JSON",
                success: function (results, status) {
                    if (results.hasOwnProperty("type")) {
                        if (results.type == "danger") {
                            if ($('#alert').length > 0) { $("#alert").remove(); }
                            Alert.getAlerts(results, resultContainer);
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


    static update()
    {

        
    }



}