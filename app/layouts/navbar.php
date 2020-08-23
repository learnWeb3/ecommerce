<header>

    <nav>

        <ul>
            <li id="menu-open"><img src="<?php echo ABSOLUTE_ASSET_PATH . "/icons/navigation/menu.svg" ?>" alt="logo icon"></li>
        </ul>


        <ul id="nav-brand-container">
            <li><img src="<?php echo ABSOLUTE_ASSET_PATH . "/icons/logo/logo.svg" ?>" alt="logo icon" class="nav-brand"></li>
        </ul>


        <ul id="search-form-container">
            <li>
                <form action="" method="post" class="form-inline">
                    <input type="search" name="" id="">
                    <select name="" id="" class="w-33 ml-1">
                        <option value=""></option>
                        <option value=""></option>
                        <option value=""></option>
                        <option value=""></option>
                    </select>
                    <button type="submit" class="btn btn-sm btn-success ml-1">valider</button>
                </form>
            </li>
        </ul>

        <ul>
            <li id="shopping-cart"><img src="<?php echo ABSOLUTE_ASSET_PATH . "/icons/action/shopping_cart.svg" ?>" alt="logo icon">
                <div class="badge-shopping-cart"></div>
            </li>
        </ul>

    </nav>

    <?php require_once 'hamburger-menu.php' ?>


    <?php require_once 'shopping-cart.php' ?>


</header>