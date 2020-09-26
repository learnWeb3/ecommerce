<div id="menu" class="closed">

    <ul>
        <li class="menu-close"><img src="<?php echo ABSOLUTE_ASSET_PATH . "/icons/navigation/close.svg" ?>" alt="logo icon"></li>
    </ul>

    <ul>
        <li><a href="<?php echo REDIRECT_BASE_URL . "controller=home&method=index" ?>" class="hamburger-link">Accueil</a></li>
        <?php if (!isset($current_user)) : ?>
            <li><a href="<?php echo REDIRECT_BASE_URL . "controller=session&method=new" ?>" class="hamburger-link">Connexion</a></li>
            <li><a href="<?php echo REDIRECT_BASE_URL . "controller=user&method=new" ?>" class="hamburger-link">Inscription</a></li>
        <?php else : ?>
            <li><a href="<?php echo REDIRECT_BASE_URL . "controller=user&method=edit" ?>" id="edit" class="hamburger-link">Mon profil</a></li>
            <li><a href="<?php echo REDIRECT_BASE_URL . "controller=session&method=destroy" ?>" id="sign-out" class="hamburger-link">Deconnexion</a></li>
        <?php endif; ?>

        <li>


            <form action="" method="POST">


                <div class="form-group">

                    <label for="menu-search">Rechercher un article:</label>

                    <input type="search" name="menu-search" id="menu-search">

                </div>


                <button type="submit" class="btn btn-lg btn-primary">valider</button>

            </form>


        </li>
    </ul>




</div>