<form action="<?php echo REDIRECT_BASE_URL . "controller=book&method=create" ?>" method="post" enctype="multipart/form-data">

    <h2>Ajouter un produit:
        <small class="my-4">(* champs obligatoires)</small></h2>

    <div class="row">


        <div class="form-group  col-12 col-md-6">

            <label for="product_title">Titre * </label>
            <input type="text" class="form-control" name="product_title" required>

        </div>


        <div class="form-group col-12 col-md-6">

            <label for="product_category_id">Catégorie * </label>

            <select name="product_category_id" id="product_category_id" class="form-control" required>

                <?php foreach ($categories as $category) : ?>

                    <option value="<?php echo $category->getId() ?>"><?php echo $category->getName() ?></option>

                <?php endforeach; ?>

            </select>
        </div>

    </div>


    <div class="row">

        <div class="form-group col-12 col-md-6">

            <label for="product_author">Auteur *</label>
            <input type="text" class="form-control" name="product_author" id="product_author" required>

        </div>

        <div class="form-group col-12 col-md-6">

            <label for="product_collection">Collection * </label>
            <input type="text" class="form-control" name="product_collection" id="product_collection" required>

        </div>

    </div>

    <div class="row">

        <div class="form-group col-12 col-md-4">

            <label for="product_price">Prix * </label>
            <input type="number" class="form-control" name="product_price" id="product_price" required>

        </div>

        <div class="form-group col-12 col-md-4">

            <label for="product_publication_date">Date de publication * </label>
            <input type="date" class="form-control" name="product_publication_date" id="product_publication_date" required>

        </div>


        <div class="form-group col-12 col-md-4">

            <label for="tva_code">Code TVA * </label>
            <select name="book_tva_id" class="form-control" required>
                <?php foreach ($tva_types as $tva) : ?>
                    <option value="<?php echo $tva['id'] ?>"><?php echo $tva['code'] ?></option>
                <?php endforeach; ?>
            </select>


        </div>

    </div>

    <div class="row">

        <div class="form-group col-12 col-md-6">

            <label for="product_image_upload">Image (upload) * </label>
            <input type="file" class="form-control" name="product_image_upload">

        </div>

        <div class="form-group col-12 col-md-6">

            <label for="product_image_url">Image (url) * </label>
            <input type="text" class="form-control" name="product_image_url">

        </div>

    </div>

    <div class="form-group">
        <label for="product_quantity">Quantitée * </label>
        <input type="number" name="product_quantity" id="product_quantity">

    </div>

    <div class="form-group">
        <label for="product_description">Description: * </label>
        <textarea name="product_description" id="product_description" cols="30" rows="10" class="form-control"></textarea>

    </div>

    <button type="submit" class="btn btn-lg btn-success col-12 col-md-2">valider</button>

</form>