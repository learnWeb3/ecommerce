<div id="checkout-process" class="sign_actions">

<img src="<?php echo ABSOLUTE_ASSET_PATH."/icons/navigation/close.svg"?>" alt="" id="close">

    <h2>Identification</h2>

    <div class="row divide-xl-2 divide-lg-2 divide-md-1 divide-sm-1 divide-xs-1 w-75">

        <div class="col" id="signInContainer">

            <h3>Déjà client</h3>

            <hr class="light my-2">

            <form action="<?php echo REDIRECT_BASE_URL . "controller=user&method=create" ?>" method="post" id="signIn">

                <div class="form-group">
                    <label for="user_email">Adresse email *</label>
                    <input type="email" name="user_email" id="user_email_sign_in_checkout" required>
                </div>

                <div class="form-group">
                    <label for="user_password">Mot de passe *</label>
                    <input type="password" name="user_password" id="user_password_sign_in_checkout" required>
                </div>



                <button class="btn btn-lg btn-primary my-4">Connexion</button>

            </form>


        </div>

        <div class="col" id="signUpContainer">

            <h3>Nouveau client</h3>

            <hr class="light my-2">

            <form action="<?php echo REDIRECT_BASE_URL . "controller=user&method=create" ?>" method="post" id="signUp">

                <div class="form-group">
                    <label for="user_email">Adresse email *</label>
                    <input type="email" name="user_email" id="user_email_sign_up_checkout" required>
                </div>

                <div class="form-group">
                    <label for="user_password">Mot de passe *</label>
                    <input type="password" name="user_password" id="user_password_sign_up_checkout" required>
                </div>

                <div class="form-group">
                    <label for="user_password_confirmation">Confirmer le mot de passe *</label>
                    <input type="password" name="user_password_confirmation" id="user_password_confirmation_sign_up_checkout" required>
                </div>

                <button class="btn btn-lg btn-primary my-4">incription</button>

            </form>


        </div>



    </div>

</div>

<script>
    User.create("#signUp", "#user_password_sign_up_checkout", "#user_password_sign_up_confirmation_checkout", "#signUpContainer");
    
    Session.create("#signIn", "#signInContainer");
</script>