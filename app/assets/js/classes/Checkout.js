
class Checkout {


    static getFormSignIn() {
        return (`
                <form action='index.php?controller=session&method=create' method='post' id='sign-in'>
                    <div class='form-group'>
                            <label for=''>Adresse email *</label>
                            <input type='email' name='user_email' id='user_email' required>
                    </div>
                    <div class='form-group'>
                            <label for=''>Mot de passe *</label>
                            <input type='password' name='user_password' id='user_password' required>
                    </div>

                 <button class='btn btn-lg btn-success my-4' type='submit'>connexion</button>

                </form>`).trim();
    }

    static getFormSignUp() {
        return (`
                <form action='index.php?controller=user&method=create' method='post' id='sign-up'>
                    <div class='form-group'>
                        <label for='user_email'>Adresse email *</label>
                        <input type='email' name='user_email' id='user_email' required>
                    </div>
                    <div class='form-group'>
                        <label for='user_password'>Mot de passe *</label>
                        <input type='password' name='user_password' id='user_password' required>
                    </div>
                    <div class='form-group'>
                        <label for='user_password_confirmation'>Confirmer le mot de passe *</label>
                        <input type='password' name='user_password_confirmation' id='user_password_confirmation' required>
                    </div>
                    
                    <button class='btn btn-lg btn-primary my-4' type='submit'>incription</button>
                </form>`).trim();
    }


    static signUpToggle() {
        $("#checkout-signup").click(function () {
            let self = Checkout;
            $(this).remove();
            $("#sign-in-container").find("form").remove();
            $("#sign-up-container").append(self.getFormSignUp())
            $("#sign-in-container").append("<button class='btn btn-lg btn-success my-4' id='checkout-signin'>connexion</button>");
            self.signInToggle();
            User.create("#sign-up", "#user_password", "#user_password_confirmation", "#sign-up-container", true);
        });

    }

    static confirmAdress(targeted_form) {

        $(targeted_form).submit(function (event) {
            let self = Checkout;
            event.preventDefault();
            $.ajax({
                url: 'index.php?controller=order&method=new&step=2',
                method: "POST",
                data: "confirm=true&remote=true&" + $(this).serialize(),
                dataType: "JSON",
                success: function (results, status) {

                    if (results.hasOwnProperty("type")) {
                        if (results.type == "success") {
                           self.getAvailableAdresses()
                        } else {
                        }

                        Alert.getAlerts(results,"#adress-confirmation");
                        Alert.dismissAlerts();
                    }
                },
                error: function (xhrObject, error, status) {
                    console.log(error);
                }
            })
        })

    }


    static getAvailableAdresses()
    {
         $.ajax({
            url:"index.php?controller=order&method=new&step=2",
            method:"POST",
            data:"select_adresses=true&remote=true",
            dataType:"JSON",
            success:function(results,status){
                if ($("#user_select_adress").length == 0)
                {
                    $("#adress-filling-mode form .form-group:nth-child(1) h4").remove();
                    $("#adress-filling-mode form .form-group:nth-child(1)").append("<select name='user_select_adress' id='user_select_adress'></select><button class='btn btn-lg btn-secondary my-4' type='submit' id='checkout-select-adress'>Sélectionner votre adresse</button>");
            
                }else{
                    $("#user_select_adress").children().remove();
                }
               results.adresses.forEach(element => {
                $("#user_select_adress").append("<option value='"+element.id+"'>"+element.adress+" "+element.postal_code+" "+element.city+"</option>")
               });
              
            },
            error:function(results,error,status){
                console.error(error);
            },
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
            Session.create("#sign-in", "#sign-in-container", true);
        });
    }

}
