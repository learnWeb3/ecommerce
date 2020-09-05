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
        <div class="card-autocomplete"></div>
        <div class="card-autocomplete"></div>
        <div class="card-autocomplete"></div>
        <div class="card-autocomplete"></div>
    </div>
    <img src="<?php echo ABSOLUTE_ASSET_PATH . "/icons/action/chevron_left.svg" ?>" alt="up arrow button" class="up">
    <img src="<?php echo ABSOLUTE_ASSET_PATH . "/icons/action/chevron_left.svg" ?>" alt="up arrow button" class="down">
</section>

<script>
    // $('nav #product-search-terms').keyup(function(el)
    // {
    //     var formSearch = $(this).parent("#product-search")
    //     formSearch.submit(
    //         function(event){
    //             event.preventDefault();
    //             $.ajax({
    //                 url:"/ecommerce/index.php&controller=search&method=new",
    //                 method:"POST",
    //                 data:$(this).serialize()+"&remote=true",
    //                 dataType:"JSON",
    //                 success:function(result, status){

    //                 },
    //                 error:function(result, status, error){

    //                 },
    //             })

    //         }
    //     )
    // })

    $(".autocomplete-zone .up").click(function(){
        var autocompleteZone = $(this).siblings(".block");
       var scrollPos = autocompleteZone.scrollTop();
       autocompleteZone.scrollTop(scrollPos - 50);
    });

    $(".autocomplete-zone .down").click(function(){
        var autocompleteZone = $(this).siblings(".block");
       var scrollPos = autocompleteZone.scrollTop();
       autocompleteZone.scrollTop(scrollPos + 50);
    });
</script>