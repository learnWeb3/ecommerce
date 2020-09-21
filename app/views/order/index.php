<?php if (isset($_GET['step'])) : ?>


    <?php if ($_GET['step'] == "1") : ?>


        <section class="container justify-content-center my-5" style="min-height:100vh">

            <div class="row divide-xl-1 divide-lg-1 divide-md-1 divide-sm-1 divide-xs-1" style="min-height:unset">

                <div class="col" id="sign-in-container">

                    <h1 class="text-center">Bonjour</h1>

                    <h2 class="text-center"><small class="my-4">(champs obligatoires *)</small></h2>

                    <hr class="light my-2">


                    <form action="<?php echo REDIRECT_BASE_URL . "controller=session&method=create" ?>" method="post" id="sign-in">

                        <div class="form-group">
                            <label for="">Adresse email *</label>
                            <input type="email" name="user_email" id="user_email" required>
                        </div>

                        <div class="form-group">
                            <label for="">Mot de passe *</label>
                            <input type="password" name="user_password" id="user_password" required>
                        </div>


                        <button class="btn btn-lg btn-success my-4" type="submit">connexion</button>
                    </form>
                </div>
            </div>

            <div class="row divide-xl-1 divide-lg-1 divide-md-1 divide-sm-1 divide-xs-1" style="min-height:unset">

                <div class="col" id="sign-up-container">

                    <h2 class="text-center">Je suis nouveau ici</h2>

                    <hr class="light my-2">

                    <button class="btn btn-lg btn-primary my-4" id="checkout-signup">inscription </button>

                </div>
            </div>
        </section>


    <?php elseif ($_GET['step'] == "2") : ?>
        <section class="container justify-content-center my-5" style="min-height:100vh">

            <div class='row divide-xl-1 divide-lg-1 divide-md-1 divide-sm-1 divide-xs-1' style='min-height:unset'>

                <h1 class='text-center'>Adresse de livraison:</h1>

                <h2 class='text-center'><small class='my-4'>(champs obligatoires *)</small></h2>

                <form action='index.php?controller=order&method=new&step=2&confirm=true' method='post' id='adress-confirmation'>

                    <div class='form-group'>
                        <label for='user_adress'>Adresse postale *</label>
                        <input type='text' name='user_address' id='user_adress' required>
                    </div>

                    <div class='form-group'>
                        <label for='user_city'>Ville *</label>
                        <input type='text' name='user_city' id='user_city' required>
                    </div>

                    <div class='form-group'>
                        <label for='user_city'>Code postal *</label>
                        <input type='number' name='user_postal_code' id='user_postal_code' required pattern='[0-9]{5}'>
                    </div>

                    <div class='form-group'>
                        <label for='user_lastname'>Nom *</label>
                        <input type='text' name='user_lastname' id='user_lastname' required>
                    </div>

                    <div class='form-group'>
                        <label for='user_firstname'>Prénom *</label>
                        <input type='text' name='user_firstname' id='user_firstname' required>
                    </div>

                    <button class='btn btn-lg btn-primary my-4' type='submit'>valider</button>

                </form>

            </div>


            </div>


        <?php elseif ($_GET['step'] == "3") : ?>




        <?php endif; ?>


    <?php endif; ?>

    <script>
        Checkout.signUpToggle();
        Session.create("#sign-in", "#sign-in-container", true);
    </script>