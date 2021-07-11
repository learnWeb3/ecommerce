<div id="checkout-process" class="delivery_details">

    <h2>Identification</h2>

    <div class="row divide-xl-2 divide-lg-2 divide-md-1 divide-sm-1 divide-xs-1 w-75">

        <div class="col">

            <h3>Details de livraison</h3>

            <hr class="light my-2">

            <form action="<?php echo REDIRECT_BASE_URL . "controller=user&method=create" ?>" method="post" id="delivery_details">

                <div class="form-group">
                    <label for="user_address">Adresse postale*</label>
                    <input type="text" name="user_address" id="user_adress" required>
                </div>

                <div class="form-group">
                    <label for="user_city">Ville *</label>
                    <input type="password" name="user_city" id="user_city" required>
                </div>

                <div class="form-group">
                    <label for="user_postal_code">Code postal*</label>
                    <input type="text" name="user_postal_code" id="user_postal_code" required>
                </div>


                <button class="btn btn-lg btn-primary my-4"><img src="<?php echo ABSOLUTE_ASSET_PATH."/icons/action/shopping_basket.svg"?>" alt="basket icon"></button>

            </form>


        </div>

    

    </div>

</div>