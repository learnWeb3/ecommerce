<form action="<?php echo REDIRECT_BASE_URL . "controller=books&method=create" ?>" method="post" enctype="multipart/form-data">

    <h2>Ajouter un produit: 
    <small class="my-4">(* champs obligatoires)</small></h2>

    <div class="row">


        <div class="form-group  col-12 col-md-6">

            <label for="">Titre * </label>
            <input type="text" class="form-control" name="product_title" required>

        </div>


        <div class="form-group col-12 col-md-6">

            <label for="">Catégorie * </label>

            <select name="product_category_id" id="product_category_id" class="form-control" required>

                <?php foreach ($categories as $category) : ?>

                    <option value="<?php echo $category->getId() ?>"><?php echo $category->getName() ?></option>

                <?php endforeach; ?>

            </select>
        </div>

    </div>


    <div class="row">

        <div class="form-group col-12 col-md-6">

            <label for="">Auteur *</label>
            <input type="text" class="form-control" name="product_author" required>

        </div>

        <div class="form-group col-12 col-md-6">

            <label for="">Collection * </label>
            <input type="text" class="form-control" name="product_collection" required>

        </div>

    </div>

    <div class="row">

        <div class="form-group col-12 col-md-6">

            <label for="">Prix * </label>
            <input type="number" class="form-control" name="product_price" required>

        </div>

        <div class="form-group col-12 col-md-6">

            <label for="">Année de publication * </label>
            <input type="text" class="form-control" name="product_year" pattern="\d{4}" required>

        </div>

    </div>

    <div class="row">

        <div class="form-group col-12 col-md-6">

            <label for="">Image (upload) * </label>
            <input type="file" class="form-control" name="product_image_upload">

        </div>

        <div class="form-group col-12 col-md-6">

            <label for="">Image (url) * </label>
            <input type="text" class="form-control" name="product_image_url">

        </div>

    </div>

    <div class="form-group">
        <label for="">Description: * </label>
        <textarea name="" id="" cols="30" rows="10" class="form-control" name="product_description"></textarea>

    </div>

    <button type="submit" class="btn btn-lg btn-success col-12 col-md-2">valider</button>

</form>