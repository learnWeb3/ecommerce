<div id="search-menu" class="closed">

    <ul>
        <li class="menu-close"><img src="<?php echo ABSOLUTE_ASSET_PATH . "/icons/navigation/close.svg" ?>" alt="logo icon"></li>
    </ul>

    <div class="container p-4">

        <h2>Votre recherche</h2>

    
        <form action="" method="post" class="w-100">

            <div class="form-group">
                <label for="" >Type de livre :</label>
                <select name="" id="">
                    <option value=""></option>
                    <option value=""></option>
                    <option value=""></option>
                    <option value=""></option>
                </select>
            </div>


            <div class="form-group">


                <label>Votre budget:</label>

                <div class="flex-no-wrap">
                    <div class="form-group w-100">
                        <label for="">0-9 &euro;</label>
                        <input type="radio" name="price-filter">
                    </div>
                    <div class="form-group w-100">
                        <label for="">10-50 &euro;</label>
                        <input type="radio" name="price-filter">
                    </div>
                    <div class="form-group w-100">
                        <label for="">+50 &euro;</label>
                        <input type="radio" name="price-filter">
                    </div>
                </div>


            </div>



            <div class="form-group">


                <h4>Filtrer les resulats:</h4>

                <div class="flex-no-wrap">
                    <div class="form-group w-100">
                        <label for="">A-Z :</label>
                        <input type="radio" name="sort-by">
                    </div>
                    <div class="form-group w-100">
                        <label for="">Prix:</label>
                        <input type="radio" name="sort-by">
                    </div>
                    <div class="form-group w-100">
                        <label for="">Date:</label>
                        <input type="radio" name="sort-by">
                    </div>
                </div>


            </div>




            <button type="submit" class="btn btn-lg btn-success">rechercher</button>



        </form>


    </div>


</div>