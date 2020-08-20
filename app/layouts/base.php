<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php $title ?></title>
    <meta name="author" content="Antoine LE GUILLOU">
    <meta name="description" content="<?php $description ?>">
</head>

<body>

    <?php require_once LAYOUT_PATH . "/navbar.php" ?>

    <?php $yield ?>

    <?php require_once LAYOUT_PATH . "/footer.php" ?>

</body>

</html>