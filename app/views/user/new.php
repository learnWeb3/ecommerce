<section class="container" style="background-image:url(<?php echo ABSOLUTE_ASSET_PATH . "/img/overlay-sign-up.jpg" ?>)">
    <div class="row divide-xl-1 divide-lg-1 divide-md-1 divide-sm-1 divide-xs-1" style="min-height:100vh">

        <div class="col" id="sign-container">

            <img src="<?php echo ABSOLUTE_ASSET_PATH . "/icons/logo/logo.svg" ?>" alt="logo">


            <small class="my-4 text-center">champs obligatoires *</small>


            <form action="<?php echo REDIRECT_BASE_URL . "controller=user&method=create" ?>" method="post" id="sign-up">

                <div class="form-group">
                    <label for="user_email">Adresse email *</label>
                    <input type="email" name="user_email" id="user_email" required>
                </div>

                <div class="form-group">
                    <label for="user_password">Mot de passe *</label>
                    <input type="password" name="user_password" id="user_password" required>
                </div>

                <div class="form-group">
                    <label for="user_password_confirmation">Confirmer le mot de passe *</label>
                    <input type="password" name="user_password_confirmation" id="user_password_confirmation" required>
                </div>

                <button class="btn btn-lg btn-success my-4" type="submit">incription</button>
                
            

            </form>
        </div>
    </div>
</section>

<script>
    User.create("#sign-up", "#user_password", "#user_password_confirmation","#sign-container");
</script>