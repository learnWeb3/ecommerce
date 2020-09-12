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
                        if (results.hasOwnProperty("type") && results.type == "danger") {

                            if ($('#alert').length > 0) {$("#alert").remove();}
                            $("#sign-container").append("<div id='alert' class='" + results.type + "'><img src='app/assets/icons/navigation/close.svg' alt='' id='close'></div>");
                            let alert = $("#alert");
                            results.message.forEach(element => {
                                alert.append("<p>" + element + "</p>")
                            });
                            $("#alert #close").click(function(){$("#alert").remove()});
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
}