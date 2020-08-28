<div id="shopping-cart-menu" class="closed">

    <ul>
        <li class="menu-close"><img src="<?php echo ABSOLUTE_ASSET_PATH . "/icons/navigation/close.svg" ?>" alt="logo icon"></li>
    </ul>

    <div class="container p-4">

        <h2>Mon panier (<?php echo 0; ?> article)</h2>

        <img src="<?php echo ABSOLUTE_ASSET_PATH . "/icons/illustration/empty-basket.svg" ?>" alt="empty basket illustration" id="empty-basket">

        <a href="" class="btn btn-lg btn-success my-2">Les produits </a>


        <div class="container-block">

            <div class="card-product">


                <div class="col">
                    <img src="" alt="" class="product-presentation">
                </div>
                <div class="col">

                    <h2 class="product-title">Super livre 1</h2>

                    <p class="product-description">Lorem ipsum dolor, sit amet consectetur adipisicing elit. Corrupti explicabo dolorum ab a molestias, fugiat quos fuga. Possimus, numquam nostrum! Quam eaque nobis aspernatur unde itaque tenetur porro delectus animi!</p>



                    <hr class="light my-2">


                    <form action="" method="post">


                        <input type="hidden" name="product-id" value="<?php ?>">

                        <div class="form-group">

                            <label for="">Quantitée :</label>

                            <select name="product-quantity" id="">
                                <option value="">1</option>
                                <option value="">2</option>
                                <option value="">3</option>
                            </select>
                        </div>

                    </form>
                </div>



                <img src="<?php echo ABSOLUTE_ASSET_PATH . "/icons/navigation/close.svg" ?>" alt="remove product icon" class="delete-product">


            </div>



        </div>

    </div>


</div>