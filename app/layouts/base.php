<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $title ?></title>
    <meta name="author" content="Antoine LE GUILLOU">
    <meta name="description" content="<?php echo $description ?>">
    <link rel="stylesheet" href="<?php echo ABSOLUTE_ASSET_PATH . "/css/main.css" ?>">
    <script src="<?php echo ABSOLUTE_ASSET_PATH . "/vendor/jquery-3.5.1.min.js" ?>"></script>
</head>

<body>

    <?php require_once LAYOUT_PATH . "/navbar.php" ?>

    <main>
        <?php echo  $yield ?>
    </main>

    <?php require_once LAYOUT_PATH . "/footer.php" ?>


    <script>
        $(window).scroll(function() {
            var scrollPos = $(this).scrollTop();
            var navHeight = $('nav').outerHeight();
            if (scrollPos > navHeight) {
                $('nav').addClass('fixed')
            } else {
                $('nav').removeClass('fixed')
            }
        })
    </script>

</body>

</html>