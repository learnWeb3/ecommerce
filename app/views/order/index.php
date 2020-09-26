<article class="bg-primary-circle-circle py-6">

    <?php if (isset($_GET['step'])) : ?>


        <?php if ($_GET['step'] == "1") : ?>


            <section class="container justify-content-center" style="min-height:100vh">

                <div class="row divide-xl-1 divide-lg-1 divide-md-1 divide-sm-1 divide-xs-1" style="min-height:unset">

                    <div class="col" id="sign-in-container">

                        <h1>1/3 Identification</h1>

                        <h2 class="text-center">Connexion</h2>

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
            <section class="container justify-content-center" style="min-height:100vh">

                <div class='row divide-xl-1 divide-lg-1 divide-md-1 divide-sm-1 divide-xs-1 my-8' style='min-height:unset'>


                    <form action='index.php?controller=order&method=new&step=2&confirm=true' method='post' id='adress-confirmation' class="p-8">

                        <h1>2/3 Adresse de livraison:</h1>

                        <h2 class="text-center">Ajouter une adresse</h2>

                        <h2 class='text-center'><small class='my-4'>(champs obligatoires *)</small></h2>


                        <div class='form-group'>
                            <label for='user_adress'>Adresse postale *</label>
                            <input type='text' name='user_address' id='user_adress' required>
                        </div>

                        <div class="flex">
                            <div class='form-group form-responsive'>
                                <label for='user_city'>Ville *</label>
                                <input type='text' name='user_city' id='user_city' required>
                            </div>

                            <div class='form-group form-responsive'>
                                <label for='user_city'>Code postal *</label>
                                <input type='number' name='user_postal_code' id='user_postal_code' pattern="[0-9]{5}" required>
                            </div>

                        </div>
                        <div class="flex">
                            <div class='form-group form-responsive'>
                                <label for='user_lastname'>Nom *</label>
                                <input type='text' name='user_lastname' id='user_lastname' required>
                            </div>

                            <div class='form-group form-responsive'>
                                <label for='user_firstname'>Prénom *</label>
                                <input type='text' name='user_firstname' id='user_firstname' required>
                            </div>
                        </div>


                        <input type="hidden" name="confirm" value="true">

                        <button class='btn btn-lg btn-primary my-4' type='submit'>valider</button>

                    </form>

                    <div id="adress-filling-mode" class="justify-self-center">


                        <hr class='light my-4'>

                        <form action="<?php echo REDIRECT_BASE_URL . "controller=order&method=new&step=3" ?>" method="POST">

                            <div class='form-group'>
                                <label for='user_select_adress'>Adresse postale *</label>

                                <?php if (!empty($adresses)) : ?>
                                    <select name="user_select_adress" id="user_select_adress">

                                        <?php foreach ($adresses as $adress) : ?>

                                            <option value="<?php echo $adress['id'] ?>"><?php echo $adress['adress'] . " " . $adress['postal_code'] . " " . $adress['city'] ?></option>

                                        <?php endforeach; ?>

                                    </select>

                                    <button class='btn btn-lg btn-secondary my-4' type="submit" id='checkout-select-adress'>Sélectionner votre adresse</button>

                                <?php else : ?>

                                    <h4>Vous n'avez pas encore d'addresses enregistrée</h4>

                                <?php endif; ?>
                            </div>
                        </form>


                    </div>

                </div>


                </div>


            <?php elseif ($_GET['step'] == "3") : ?>


                <section class="container justify-content-center">

                    <div class='row divide-xl-2 divide-lg-2 divide-md-1 divide-sm-1 divide-xs-1 my-8 align-items-center' style="min-height:80vh">

                        <div class="col" style="height:75vh;position: relativey;z-index: 0;">
                            <div class="container-block" id="checkout-confirmation" style="max-height:75%">

                                <?php if ($basket->notEmpty()) : ?>

                                    <?php foreach ($basket_products as $basket_product) : ?>

                                        <?php require LAYOUT_PATH . '/partials/basket_item/basket_item_product.php' ?>

                                    <?php endforeach; ?>

                                <?php endif; ?>

                            </div>
                        </div>

                        <div class="col" style="height:75vh">

                            <h1 class='text-center'>Récapitulatif de votre commande:</h1>

                            <div class="w-100" id="basket-price-zone" style="display:<?php echo $basket->getPriceZoneDisplay() ?>">
                                <h2>Total:</h2>
                                <hr class="light my-2">
                                <h3 id="basket-total-HT-checkout">Sous-total (HT): <?php echo $basket->getTotalHT() ?> &euro;</h3>
                                <h3>Livraison:</h3>
                                <hr class="light my-2">
                                <h2 id="basket-total-TTC-checkout">Total (TVA incluse): <?php echo $basket->getTotalTTC() ?> &euro;</h2>
                                <h3>Adresse:</h3>
                                <hr class="light my-2">
                                <h2 id="user_delivery_adress">Adresse: <?php echo $delivery_address ?></h2>
                                <buttton class="btn btn-lg btn-success my-4" id="stripe-checkout">Payer</buttton>

                            </div>

                        </div>



                    </div>


                </section>



            <?php endif; ?>


        <?php endif; ?>

</article>



<!-- PAGE SPECIFIC SCRIPT -->
<script src="<?php echo ABSOLUTE_ASSET_PATH."/js/page_specific/order/index.js"?>"></script>