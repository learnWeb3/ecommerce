<section class="container">
    <div class="row divide-xl-2 divide-lg-2 divide-md-2 divide-sm-1 divide-xs-1 bg-primary" style="min-height:100vh;padding-top:8rem">

        <div class="col justify-content-start">

            <h1>Mon profil:  <small class="my-4 text-center">champs obligatoires *</small></h1>


            <form action="<?php echo REDIRECT_BASE_URL . "controller=user&method=create" ?>" method="post" id="sign-in">

                <hr class="light my-2">

                <h2>Informations de connexion:</h2>

                <div class="form-group">
                    <label for="user_email">Adresse email *</label>
                    <input type="email" name="user_email" id="user_email" value="<?php echo $current_user->getEmail()?>" required>
                </div>

                <div class="form-group">
                    <label for="user_password">Mot de passe *</label>
                    <input type="password" name="user_password" id="user_password" required>
                </div>

                <div class="form-group">
                    <label for="user_password_confirmation">Confirmer le mot de passe *</label>
                    <input type="password" name="user_password_confirmation" id="user_password_confirmation" required>
                </div>

        </div>
        <div class="col justify-content-start">

            <h2>Informations personnelles:</h2>

            <hr class="light my-2">

            <div class="form-group">
                <label for="user_firstname">Prénom </label>
                <input type="text" name="user_firstname" id="user_firstname" value="<?php echo $current_user->getFirstname()?>" required>
            </div>

            <div class="form-group">
                <label for="user_lastname">Nom </label>
                <input type="text" name="user_lastname" id="user_lastname" value="<?php echo $current_user->getLastname()?>" required>
            </div>

            <div class="form-group">
                <label for="user_dateofbirth">Date de naissance </label>
                <input type="date" name="user_dateofbirth" id="user_dateofbirth" value="<?php echo $current_user->getDateOfBirth()?>" required>
            </div>


            <button class="btn btn-lg btn-success my-4">valider</button>


            </form>
        </div>

    </div>
</section>