<header>

    <nav>

        <ul>
            <li id="menu-open"><img src="<?php echo ABSOLUTE_ASSET_PATH . "/icons/navigation/menu.svg" ?>" alt="logo icon"></li>
        </ul>


        <ul id="nav-brand-container">
            <li><a href="<?php echo REDIRECT_BASE_URL."controller=home&method=index" ?>"><img src="<?php echo ABSOLUTE_ASSET_PATH . "/icons/logo/logo.svg" ?>" alt="logo icon" class="nav-brand"></a></li>
        </ul>


        <ul id="search-form-container">
            <li>
                <form action="<?php echo REDIRECT_BASE_URL . "controller=search&method=new" ?>" method="post" class="form-inline" id="product-search">
                    <input type="search" name="search_input" id="product-search-terms">
                    <select name="search_filter" id="" class="w-33 ml-1">
                        <?php foreach ($search_filters as $search_filter) : ?>
                            <option value="<?php echo $search_filter['filter'] ?>"><?php echo $search_filter['filter_name'] ?></option>
                        <?php endforeach; ?>
                    </select>
                    <button type="submit" class="btn btn-sm btn-success ml-1">valider</button>
                </form>
            </li>
        </ul>

        <ul>
            <li class="mr-4 relative"><img src="<?php echo ABSOLUTE_ASSET_PATH . "/icons/action/user.svg" ?>" id="user_sign_action" alt="user icon">
                <ul class="toogle d-none">
                <?php if (!isset($current_user)):?>
                    <li><a href="<?php echo REDIRECT_BASE_URL."controller=session&method=new"?>">Connexion</a></li>
                    <li><a href="<?php echo REDIRECT_BASE_URL."controller=user&method=new"?>">Inscription</a></li>
                <?php else:?>
                    <li><a href="<?php echo REDIRECT_BASE_URL."controller=user&method=edit"?>" id="edit">Mon profil</a></li>
                    <li><a href="<?php echo REDIRECT_BASE_URL."controller=session&method=destroy"?>" id="sign-out">Deconnexion</a></li>
                <?php endif;?>
                </ul>
            </li>
            <li id="search-open" class="mr-4"><img src="<?php echo ABSOLUTE_ASSET_PATH . "/icons/action/search.svg" ?>" alt="search icon" title="rechercher un produit"></li>
            <li id="shopping-cart"><img src="<?php echo ABSOLUTE_ASSET_PATH . "/icons/action/shopping_cart.svg" ?>" alt="logo icon" title="voir le panier">
                <div class="badge-shopping-cart"></div>
            </li>
        </ul>

    </nav>


    <?php require_once 'hamburger-menu.php' ?>


    <?php require_once 'shopping-cart.php' ?>


    <?php require_once 'search-menu.php' ?>


</header>



<section class="autocomplete-zone">
    <div class="block">
    </div>
    <img src="<?php echo ABSOLUTE_ASSET_PATH . "/icons/action/chevron_left.svg" ?>" alt="up arrow button" class="up">
    <img src="<?php echo ABSOLUTE_ASSET_PATH . "/icons/action/chevron_left.svg" ?>" alt="up arrow button" class="down">
</section>


<script src="<?php echo ABSOLUTE_ASSET_PATH."/js/nav_actions.js"?>"></script>