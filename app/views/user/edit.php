<section class="container bg-primary-circle">


    <ul class="tab-container px-4 py-8" style="padding-top:10rem">
        <li class="tab" id="my-account">Mon profil</li>
        <li class="tab" id="my-order">Mes commandes</li>
    </ul>

    <div class="row divide-xl-2 divide-lg-2 divide-md-2 divide-sm-1 divide-xs-1 active" style="min-height:100vh;" id="tab-my-account">
        <div class="col justify-content-start">

            <h1>Mon profil: <small class="my-4 text-center">champs obligatoires *</small></h1>

            <form action="<?php echo REDIRECT_BASE_URL . "controller=user&method=update" ?>" method="post" id="sign-in">

                <hr class="light my-2">

                <h2>Informations de connexion:</h2>

                <div class="form-group">
                    <label for="user_email">Adresse email *</label>
                    <input type="email" name="user_email" id="user_email" value="<?php echo $current_user->getEmail() ?>" required>
                </div>

                <div class="form-group">
                    <label for="user_password">Mot de passe *</label>
                    <input type="password" name="user_password" id="user_password" required>
                </div>

                <div class="form-group">
                    <label for="user_password_confirmation">Confirmer le mot de passe *</label>
                    <input type="password" name="user_password_confirmation" id="user_password_confirmation" required>
                </div>


                <button class="btn btn-lg btn-success my-4">valider</button>


            </form>

        </div>
        <div class="col justify-content-start">

            <h2>Informations personnelles:</h2>

            <form action="<?php echo REDIRECT_BASE_URL . "controller=user&method=update" ?>" method="post" id="sign-in">

                <hr class="light my-2">

                <div class="form-group">
                    <label for="user_firstname">Prénom </label>
                    <input type="text" name="user_firstname" id="user_firstname" value="<?php echo $current_user->getFirstname() ?>" required>
                </div>

                <div class="form-group">
                    <label for="user_lastname">Nom </label>
                    <input type="text" name="user_lastname" id="user_lastname" value="<?php echo $current_user->getLastname() ?>" required>
                </div>

                <div class="form-group">
                    <label for="user_dateofbirth">Date de naissance </label>
                    <input type="date" name="user_dateofbirth" id="user_dateofbirth" value="<?php echo $current_user->getDateOfBirth() ?>" required>
                </div>


                <button class="btn btn-lg btn-success my-4">valider</button>


            </form>
        </div>

    </div>

    <div class="row divide-xl-2 divide-lg-2 divide-md-2 divide-sm-1 divide-xs-1 hidden" style="min-height:100vh;display:none" id="tab-my-order">

        <?php foreach ($order_chunks as $order_chunk) : ?>

            <div class="col">

                <?php foreach ($order_chunk as $order) : ?>

                    <div class="card-invoice">

                        <div class="col">

                            <img src="<?php echo ABSOLUTE_ASSET_PATH . "/icons/logo/logo.svg" ?>" alt="logo">

                        </div>

                        <div class="col">

                            <h2>Facture N°<?php echo $order['invoice']->getId() ?></h2>

                            <h2>Nombre d'articles: <?php echo $order['invoice_item_count']?></h2>

                            <h3>Montant TTC: <?php echo $order['invoice']->getTotalAmountTTC() ?> &euro;</h3>

                            <h3>Montant HT: <?php echo $order['invoice']->getTotalAmountHT() ?> &euro;</h3>

                            <a href="<?php echo REDIRECT_BASE_URL."controller=invoice&method=show&id=".$order['invoice']->getId() ?>" class="btn btn-secondary btn-lg my-2">Voir plus</a>

                        </div>

                    </div>

                <?php endforeach ?>
            </div>

        <?php endforeach; ?>
    </div>
</section>


<!-- PAGE SPECIFIC SCRIPT -->
<script src="<?php echo ABSOLUTE_ASSET_PATH."/js/page_specific/user/edit.js"?>"></script>