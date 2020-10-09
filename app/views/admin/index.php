<ul class="nav nav-tabs" id="myTab" role="tablist">
    <li class="nav-item" role="presentation">
        <a class="nav-link" id="product-tab" data-toggle="tab" href="#product" role="tab" aria-controls="product" aria-selected="true">Les produits</a>
    </li>
    <li class="nav-item" role="presentation">
        <a class="nav-link" id="product-create-tab" data-toggle="tab" href="#product-create" role="tab" aria-controls="product-create" aria-selected="false">Ajouter un produit</a>
    </li>
    <li class="nav-item" role="presentation">
        <a class="nav-link" id="activity-tab" data-toggle="tab" href="#activity" role="tab" aria-controls="activity" aria-selected="true">Mon activité</a>
    </li>
    <li class="nav-item" role="presentation">
        <a class="nav-link" id="user-tab" data-toggle="tab" href="#user" role="tab" aria-controls="user" aria-selected="false">Les utilisateurs</a>
    </li>
    <li class="nav-item" role="presentation">
        <a class="nav-link" id="order-tab" data-toggle="tab" href="#order" role="tab" aria-controls="order" aria-selected="false">Les commandes</a>
    </li>
</ul>


<div class="tab-content" id="myTabContent">


    <div class="tab-pane fade show active p-4" id="product" role="tabpanel" aria-labelledby="product-tab">

        <?php require_once LAYOUT_PATH . '/partials/admin/product_tab_content.php' ?>

        <ul class="pagination my-4 d-flex justify-content-end">
            <li>
                <a href="<?php echo REDIRECT_BASE_URL . "controller=admin&method=index" ?>" class="btn btn-lg btn-warning">reinitialiser la recherche</a>
            </li>
            <li class="ml-2">
                <form action="<?php echo REDIRECT_BASE_URL . "controller=admin&method=index" ?>" method="GET" id="form-page-previous">
                    <?php foreach ($_GET as $key => $value) : ?>
                        <?php if ($key != 'start') : ?>
                            <input type="hidden" name="<?php echo $key ?>" value="<?php echo $value ?>">
                        <?php endif; ?>
                    <?php endforeach; ?>
                    <input type="hidden" name="start" value="<?php echo $previous ?>">
                    <button type="submit" class="btn btn-lg btn-primary" id="previous"><img src="<?php echo ABSOLUTE_ASSET_PATH . "/icons/action/chevron_left_white.svg" ?>" alt="icon right page"></button>
                </form>
            </li>
            <li class="ml-2">
                <form action="<?php echo REDIRECT_BASE_URL . "controller=admin&method=index" ?>" method="GET" id="form-page-next">
                    <?php foreach ($_GET as $key => $value) : ?>
                        <?php if ($key != 'start') : ?>
                            <input type="hidden" name="<?php echo $key ?>" value="<?php echo $value ?>">
                        <?php endif; ?>
                    <?php endforeach; ?>
                    <input type="hidden" name="start" value="<?php echo $next ?>">
                    <button type="submit" class="btn btn-lg btn-primary" id="next"><img src="<?php echo ABSOLUTE_ASSET_PATH . "/icons/action/chevron_right_white.svg" ?>" alt="icon left page"></button>
                </form>
            </li>
        </ul>


    </div>


    <div class="tab-pane fade p-4" id="product-create" role="tabpanel" aria-labelledby="product-create-tab">

        <?php require_once  LAYOUT_PATH . "/partials/admin/product_create_tab_content.php" ?>

    </div>

    <div class="tab-pane fade p-4" id="activity" role="tabpanel" aria-labelledby="activity-tab">

        <?php require_once  LAYOUT_PATH . "/partials/admin/activity_tab_content.php" ?>

    </div>

    <div class="tab-pane fade p-4" id="user" role="tabpanel" aria-labelledby="user-tab">

        <?php require_once LAYOUT_PATH . '/partials/admin/user_tab_content.php' ?>

    </div>
    <div class="tab-pane fade p-4" id="order" role="tabpanel" aria-labelledby="order-tab">

        <?php require_once LAYOUT_PATH . '/partials/admin/order_tab_content.php' ?>

    </div>


</div>


<?php require_once LAYOUT_PATH . "/flash/flash.php" ?>



<script src="<?php echo ABSOLUTE_ASSET_PATH . "/js/page_specific/admin/admin.js" ?>">

</script>