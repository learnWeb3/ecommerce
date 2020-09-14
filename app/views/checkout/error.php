<section class="container">
    <div class="row divide-xl-1 divide-lg-1 divide-md-2 divide-sm-1 divide-xs-1 bg-primary-circle-circle" style="min-height:100vh;padding-top:8rem">

        <div class="col justify-content-center align-items-center">
            <img src="<?php echo ABSOLUTE_ASSET_PATH . "/icons/action/error_outline_24px_rounded.svg" ?>" alt="warning icon" class="warning">
            <h1>Une erreure est survenue</h1>

            <div class="w-25">

                <a href="<?php echo REDIRECT_BASE_URL."controller=home&method=index"?>" class="btn btn-lg btn-success my-2">Accueil</a>
                <a href="<?php echo REDIRECT_BASE_URL."controller=book&method=index"?>" class="btn btn-lg btn-primary my-2">La Boutique</a>

            </div>
        </div>
    </div>

</section>