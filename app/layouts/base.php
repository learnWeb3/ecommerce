<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $title ?></title>
    <meta name="author" content="Antoine LE GUILLOU">
    <meta name="description" content="<?php echo $description ?>">
    <!-- MAIN STYLESHEET -->
    <link rel="stylesheet" href="<?php echo ABSOLUTE_ASSET_PATH . "/css/main.css" ?>">
    <!-- JQUERY LIBRARY -->
    <script src="<?php echo ABSOLUTE_ASSET_PATH . "/vendor/jquery-3.5.1.min.js" ?>"></script>
    <!-- STRIPE JS  -->
    <script src="https://js.stripe.com/v3/"></script>
    <!-- NAVBAR JS STYLES -->
    <script src="<?php echo ABSOLUTE_ASSET_PATH . "/js/navbar.js" ?>"></script>
    <script src="<?php echo ABSOLUTE_ASSET_PATH."/js/input-number.js"?>"></script>
    <script src="<?php echo ABSOLUTE_ASSET_PATH?>/js/classes/Alert.js"></script>
    <script src="<?php echo ABSOLUTE_ASSET_PATH?>/js/classes/Session.js"></script>
    <script src="<?php echo ABSOLUTE_ASSET_PATH?>/js/classes/User.js"></script>
    <script src="<?php echo ABSOLUTE_ASSET_PATH?>/js/classes/Basket.js"></script>
    <script src="<?php echo ABSOLUTE_ASSET_PATH ?>/js/classes/Product.js"></script>
    <script src="<?php echo ABSOLUTE_ASSET_PATH ?>/js/classes/Checkout.js"></script>
    <script src="<?php echo ABSOLUTE_ASSET_PATH?>/js/classes/Autocomplete.js"></script>
    <script src="<?php echo ABSOLUTE_ASSET_PATH?>/js/classes/AppStripe.js"></script>
</head>

<body>

    <?php require_once LAYOUT_PATH . "/navbar.php" ?>

    <main>
        <?php echo  $yield ?>
    </main>

    <?php require_once LAYOUT_PATH . "/footer.php" ?>


<script>

    $(document).ready(function(){
        appendArrowInputNumber();
    })
</script>
</body>

</html>