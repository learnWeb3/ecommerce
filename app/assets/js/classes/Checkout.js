
class Checkout {


    static getFormSignIn() {
        return "<form action='index.php?controller=session&method=create' method='post' id='sign-in'>" +

            "<div class='form-group'>" +
            "<label for=''>Adresse email *</label>" +
            "<input type='email' name='user_email' id='user_email' required>" +
            "</div>" +

            "<div class='form-group'>" +
            "<label for=''>Mot de passe *</label>" +
            "<input type='password' name='user_password' id='user_password' required>" +
            "</div>" +

            "<button class='btn btn-lg btn-success my-4' type='submit'>connexion</button>" +
            "</form>"
    }

    static getFormSignUp() {
        return "<form action='index.php?controller=user&method=create' method='post' id='sign-up'>" +

            "<div class='form-group'>" +
            "<label for='user_email'>Adresse email *</label>" +
            "<input type='email' name='user_email' id='user_email' required>" +
            "</div>" +

            "<div class='form-group'>" +
            "<label for='user_password'>Mot de passe *</label>" +
            "<input type='password' name='user_password' id='user_password' required>" +
            "</div>" +

            "<div class='form-group'>" +
            "<label for='user_password_confirmation'>Confirmer le mot de passe *</label>" +
            "<input type='password' name='user_password_confirmation' id='user_password_confirmation' required>" +
            '</div>' +

            "<button class='btn btn-lg btn-primary my-4' type='submit'>incription</button>" +
            "</form>";
    }

    static getFormConfirmAdress()
    {
        return "<div class='row divide-xl-1 divide-lg-1 divide-md-1 divide-sm-1 divide-xs-1' style='min-height:unset'>"+
        

        "<h1 class='text-center'>Adresse de livraison:</h1>"+

        "<h2 class='text-center'><small class='my-4'>(champs obligatoires *)</small></h2>"+

        "<form action='index.php?controller=order&method=new&step=3&confirm=true' method='post' id='adress-confirmation'>" +

        "<div class='form-group'>" +
        "<label for='user_adress'>Adresse postale *</label>" +
        "<input type='text' name='user_address' id='user_adress' required>" +
        "</div>" +

        "<div class='form-group'>" +
        "<label for='user_city'>Ville *</label>" +
        "<input type='text' name='user_city' id='user_city' required>" +
        "</div>" +

        "<div class='form-group'>" +
        "<label for='user_city'>Code postal *</label>" +
        "<input type='number' name='user_postal_code' id='user_postal_code' required pattern='[0-9]{5}'>" +
        "</div>" +

        "<div class='form-group'>" +
        "<label for='user_lastname'>Nom *</label>" +
        "<input type='text' name='user_lastname' id='user_lastname' required>" +
        "</div>" +

        "<div class='form-group'>" +
        "<label for='user_firstname'>Prénom *</label>" +
        "<input type='text' name='user_firstname' id='user_firstname' required>" +
        "</div>" +

        "<button class='btn btn-lg btn-primary my-4' type='submit'>valider</button>" +

        "</form>"+

        "</div>";
    }

    static signUpToggle() {
        $("#checkout-signup").click(function () {
            let self = Checkout;
            $(this).remove();
            $("#sign-in-container").find("form").remove();
            $("#sign-up-container").append(self.getFormSignUp())
            $("#sign-in-container").append("<button class='btn btn-lg btn-success my-4' id='checkout-signin'>connexion</button>");
            self.signInToggle();
            User.create("#sign-up", "#user_password", "#user_password_confirmation","#sign-up-container", true); 
        });

    }

    static confirmAdress()
    {
        $.ajax({
            url:'index.php',
            method:"POST",
            data:"controller=order&method=new&step=2&confirm=true",
            dataType:"JSON",
            success:function(results,status){

            },
            error:function(xhrObject,error,status){

            }
        })
    }


    static signInToggle() {
        $("#checkout-signin").click(function () {
            let self = Checkout;
            $(this).remove();
            $("#sign-up-container").find("form").remove();
            $("#sign-in-container").append(self.getFormSignIn())
            $("#sign-up-container").append("<button class='btn btn-lg btn-primary my-4' id='checkout-signup'>inscription </button>");
            self.signUpToggle();
        });
    }

}
