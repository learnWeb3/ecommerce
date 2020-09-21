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


    <?php elseif ($_GET['step'] == "3") : ?>

    <?php endif; ?>


<?php endif; ?>

<script>
    Checkout.signUpToggle();
    Session.create("#sign-in", "#sign-in-container");
</script>