<div id="search-menu" class="closed justify-content-center">

    <ul>
        <li class="menu-close"><img src="<?php echo ABSOLUTE_ASSET_PATH . "/icons/navigation/close.svg" ?>" alt="logo icon"></li>
    </ul>

    <div class="container p-4" style="height:unset">

        <h2>Critère de recherche</h2>


        <form action="" method="GET" class="w-100">

            <div class="form-group">

                <label for="category_name">Categorie de livre:</label>
                <select name="category_id" id="category_name" required>
                    <?php foreach ($categories as $category) : ?>
                        <option value="<?php echo $category->getId() ?>"><?php echo $category->getName() ?></option>
                    <?php endforeach; ?>
                </select>

            </div>


            <div class="form-group">


                <label>Votre budget:</label>

                <div class="flex-no-wrap">
                    <div class="form-group w-100">
                        <label for="price_max">Prix minimum:</label>
                        <select name="price_min" id="price_min" required>
                            <?php for ($i = 0; $i < 100; $i++) : ?>
                                <option value="<?php echo $i ?>"><?php echo $i ?></option>
                            <?php endfor; ?>
                        </select>
                    </div>

                    <div class="form-group w-100">
                        <label for="price_max">Prix maximum:</label>
                        <select name="price_max" id="price_min" required>
                            <?php for ($i = 0; $i <= 100; $i++) : ?>
                                <?php if ($i == 100):?>
                                    <option value="<?php echo $i ?>" selected="selected"><?php echo $i ?></option>
                                <?php else:?>
                                    <option value="<?php echo $i ?>"><?php echo $i ?></option>
                                <?php endif;?>
                            <?php endfor; ?>
                        </select>
                    </div>
                </div>


            </div>



            <div class="form-group">


                <h4>Filtrer les resulats:</h4>

                <div class="flex-no-wrap">
                    <div class="form-group w-100">
                        <label for="">A-Z :</label>
                        <input type="radio" name="order_by" value="title" checked>
                    </div>
                    <div class="form-group w-100">
                        <label for="">Prix:</label>
                        <input type="radio" name="order_by" value="price">
                    </div>
                    <div class="form-group w-100">
                        <label for="">Date:</label>
                        <input type="radio" name="order_by" value="created_at">
                    </div>
                </div>



            </div>


            <input type="hidden" name="controller" value="book">
            <input type="hidden" name="method" value="index">

            <button type="submit" class="btn btn-lg btn-success">rechercher</button>



        </form>


    </div>



</div>