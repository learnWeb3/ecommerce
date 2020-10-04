<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $title ?></title>
    <meta name="author" content="Antoine LE GUILLOU">
    <meta name="description" content="<?php echo $description ?>">

    <!-- BOOTSTRAP LIBRARY STYLES -->

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
    <link rel="stylesheet" href="<?php echo ABSOLUTE_ASSET_PATH . "/css/admin.css" ?>">
    <!-- JQUERY LIBRARY -->
    <script src="<?php echo ABSOLUTE_ASSET_PATH . "/vendor/jquery-3.5.1.min.js" ?>"></script>
    <!-- BOOTSTRAP LIBRARY JS -->
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>

    <!-- HIGHCHART JS LIBRARY -->
    <script src="https://code.highcharts.com/highcharts.js"></script>
    <!-- STRIPE JS  -->
    <script src="https://js.stripe.com/v3/"></script>
    <!-- NAVBAR JS STYLES -->
    <script src="<?php echo ABSOLUTE_ASSET_PATH . "/js/navbar.js" ?>"></script>
    <script src="<?php echo ABSOLUTE_ASSET_PATH . "/js/input-number.js" ?>"></script>
    <script src="<?php echo ABSOLUTE_ASSET_PATH ?>/js/classes/Alert.js"></script>
    <script src="<?php echo ABSOLUTE_ASSET_PATH ?>/js/classes/Session.js"></script>
    <script src="<?php echo ABSOLUTE_ASSET_PATH ?>/js/classes/User.js"></script>
    <script src="<?php echo ABSOLUTE_ASSET_PATH ?>/js/classes/Basket.js"></script>
    <script src="<?php echo ABSOLUTE_ASSET_PATH ?>/js/classes/Product.js"></script>
    <script src="<?php echo ABSOLUTE_ASSET_PATH ?>/js/classes/Checkout.js"></script>
    <script src="<?php echo ABSOLUTE_ASSET_PATH ?>/js/classes/Autocomplete.js"></script>
    <script src="<?php echo ABSOLUTE_ASSET_PATH ?>/js/classes/AppStripe.js"></script>
    <script src="<?php echo ABSOLUTE_ASSET_PATH ?>/js/classes/Admin.js"></script>
</head>

<body>

    <?php require_once LAYOUT_PATH . "/navbar_admin.php" ?>

    <main>
        <?php echo  $yield ?>
    </main>

    <?php require_once LAYOUT_PATH . "/footer.php" ?>


    <script>
        $(document).ready(function() {
            appendArrowInputNumber();
        })
    </script>
</body>

</html>