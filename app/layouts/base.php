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
    <!-- NAVBAR JS STYLES -->
    <script src="<?php echo ABSOLUTE_ASSET_PATH . "/js/navbar.js" ?>"></script>
    <script src="<?php echo ABSOLUTE_ASSET_PATH ?>/js/classes/Product.js"></script>
</head>

<body>

    <?php require_once LAYOUT_PATH . "/navbar.php" ?>

    <main>
        <?php echo  $yield ?>
    </main>

    <?php require_once LAYOUT_PATH . "/footer.php" ?>

</body>

</html>