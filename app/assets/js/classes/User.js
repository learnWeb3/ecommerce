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


    static update() {

        $("#admin-table-user form").submit(function (e) {

            // preventing default action classic http request to the server to serve a file
            e.preventDefault();


            let url = "index.php";
            let datas = $(this).serialize() + "&controller=user&method=update&remote=true";

            $.post(url, datas, function (results) {

                // results of ajax request to JSON format 
                let userDatas = JSON.parse(results);

                // object destructuring for better accessibility and redability 
                let { id, email, firstname, lastname, date_of_birth } = userDatas;

                // targeing correct row
                let targetedRow = $(`tr#user-${userDatas.id}`);

                // targeting userss input fields
                let emailInput = targetedRow.find("input[name=user_email]");
                let firstnameInput = targetedRow.find("input[name=user_firstname]");
                let lastnameInput = targetedRow.find("input[name=user_lastname]");
                let dateOfbirthInput = targetedRow.find("input[name=user_date_of_birth]");

                // Setting values
                emailInput.val(email);
                firstnameInput.val(firstname);
                lastnameInput.val(lastname);
                dateOfbirthInput.val(date_of_birth);


            });
        });

        // event blur for input 
        $('#admin-table-user form input').blur(function (e) {
            let form = $(this).parent('form')

            form.submit();
        });

        //event click for radio // TO BE REVIEWED
        $('#admin-table-user .custom-radio').click(function (e) {
            let form = $(this).parent('form')
            form.submit();
        });

    }


    static delete() {
        $("#admin-table-user form.delete").submit(function (event) {
            event.preventDefault();

            let userConfirm = confirm("Voulez vous réellement supprimé ce produit ?");

            if (userConfirm) {

                let url = "index.php";
                let datas = $(this).serialize() + "&controller=user&method=destroy&remote=true";

                $.post(url, datas, function (results) {

                    results = JSON.parse(results);

                    let {user_id} = results;
                    $(`#user-${user_id}`).remove();
                })

            }

        })
    }



}