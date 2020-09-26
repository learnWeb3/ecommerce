<ul class="nav nav-tabs" id="myTab" role="tablist">
    <li class="nav-item" role="presentation">
        <a class="nav-link active" id="product-tab" data-toggle="tab" href="#product" role="tab" aria-controls="product" aria-selected="true">Les produits</a>
    </li>
    <li class="nav-item" role="presentation">
        <a class="nav-link" id="user-tab" data-toggle="tab" href="#user" role="tab" aria-controls="user" aria-selected="false">Les utilisateurs</a>
    </li>
    <li class="nav-item" role="presentation">
        <a class="nav-link" id="order-tab" data-toggle="tab" href="#order" role="tab" aria-controls="order" aria-selected="false">Les commandes</a>
    </li>
</ul>


<div class="tab-content" id="myTabContent">
    <div class="tab-pane fade show active" id="product" role="tabpanel" aria-labelledby="product-tab">

        <?php require_once LAYOUT_PATH . '/partials/admin/product_tab_content.php' ?>

    </div>
    <div class="tab-pane fade" id="user" role="tabpanel" aria-labelledby="user-tab">

        <?php require_once LAYOUT_PATH . '/partials/admin/user_tab_content.php' ?>

    </div>
    <div class="tab-pane fade" id="order" role="tabpanel" aria-labelledby="order-tab">

        <?php require_once LAYOUT_PATH . '/partials/admin/order_tab_content.php' ?>

    </div>
</div>



<script>
    $(document).ready(function() {
        Admin.getProductDetails();
        Admin.updateProduct();
    });
</script>