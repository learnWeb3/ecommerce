<form action="" method="post" class="my-4">
    <div class="form-row">
        <div class="col">
            <input type="search" name="search_input" id="search_input" class="form-control">
        </div>
        <div class="col">
            <select name="search_filter" class="form-control">
                <?php foreach ($search_filters as $search_filter) : ?>
                    <option value="<?php echo $search_filter['filter'] ?>"><?php echo $search_filter['filter_name'] ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="col">
        <button type="submit" class="btn btn-md btn-success">valider</button>
        </div>
    </div>
</form>


<div class="table-responsive" style="max-height:60vh;">
    <table id="admin-table" class="table table-borderless table-hover">
        <thead>
            <tr>
                <th id="image" scope="col">Image</th>
                <th id="category" scope="col">Catégorie</th>
                <th id="tva" scope="col">Tva</th>
                <th id="image_url" scope="col">Image url</th>
                <th id="title" scope="col">Titre</th>
                <th id="author" scope="col">Auteur</th>
                <th id="collection" scope="col">Collection</th>
                <th id="description" scope="col">Description</th>
                <th id="price" scope="col">Prix</th>
                <th id="stock" scope="col">Stock</th>
                <th id="upload" scope="col">Upload</th>
                <th id="delete" scope="col">Supprimer</th>
                <th id="created_at" scope="col">Crée à</th>
                <th id="updated_at" scope="col">Mis à jour à</th>
            </tr>
        </thead>
        <tbody>

            <?php foreach ($books as $book) : ?>
                <tr>
                    <td>
                        <img src="<?php echo $book['book']->getImagePath() ?>" alt="<?php echo $book['book']->getTitle() . " " . "poster" ?>" style="height:8rem;width:5rem;">
                    </td>
                    <td>
                        <form action="<?php echo REDIRECT_BASE_URL . "controller=admin&method=update" ?>" method="POST">
                            <input type="hidden" name="book_id" value="<?php echo $book['book']->getId() ?>">
                            <select name="book_category_id" id="book_catgeory_id" class="form-control">
                                <?php foreach ($categories as $category) : ?>
                                    <?php if ($category->getId() == $book['book']->getCategoryId()) : ?>
                                        <option value="<?php echo $category->getId() ?>" selected><?php echo $category->getName() ?></option>
                                    <?php else : ?>
                                        <option value="<?php echo $category->getId() ?>"><?php echo $category->getName() ?></option>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            </select>
                            <button type="submit">valider</button>
                        </form>
                    </td>
                    <td>
                        <form action="<?php echo REDIRECT_BASE_URL . "controller=admin&method=update" ?>" method="POST">
                            <input type="hidden" name="book_id" value="<?php echo $book['book']->getId() ?>">
                            <select name="book_tva_id" id="book_tva_id" class="form-control">
                                <?php foreach ($tva_types as $tva) : ?>
                                    <option value="<?php echo $tva['id'] ?>"><?php echo $tva['code'] ?></option>
                                <?php endforeach; ?>
                            </select>
                            <button type="submit">valider</button>
                        </form>
                    </td>
                    <td>
                        <form action="<?php echo REDIRECT_BASE_URL . "controller=admin&method=update" ?>" method="POST">
                            <input type="hidden" name="book_id" value="<?php echo $book['book']->getId() ?>">
                            <input type="text" name="book_image_path" id="book_image_path" value="<?php echo $book['book']->getImagePath() ?>"  class="form-control">
                            <button type="submit">valider</button>
                        </form>
                    </td>
                    <td>
                        <form action="<?php echo REDIRECT_BASE_URL . "controller=admin&method=update" ?>" method="POST">
                            <input type="hidden" name="book_id" value="<?php echo $book['book']->getId() ?>">
                            <input type="text" name="book_title" id="book_title" value="<?php echo $book['book']->getTitle() ?>"  class="form-control">
                            <button type="submit">valider</button>
                        </form>
                    </td>
                    <td>
                        <form action="<?php echo REDIRECT_BASE_URL . "controller=admin&method=update" ?>" method="POST">
                            <input type="hidden" name="book_id" value="<?php echo $book['book']->getId() ?>">
                            <input type="text" name="book_author" id="book_author" value="<?php echo $book['book']->getAuthor() ?>"  class="form-control">
                            <button type="submit">valider</button>
                        </form>
                    </td>
                    <td>
                        <form action="<?php echo REDIRECT_BASE_URL . "controller=admin&method=update" ?>" method="POST">
                            <input type="hidden" name="book_id" value="<?php echo $book['book']->getId() ?>">
                            <input type="text" name="book_collection" id="book_collection" value="<?php echo $book['book']->getCollection() ?>"  class="form-control">
                            <button type="submit">valider</button>
                        </form>
                    </td>
                    <td>
                        <form action="<?php echo REDIRECT_BASE_URL . "controller=admin&method=update" ?>" method="POST">
                            <input type="hidden" name="book_id" value="<?php echo $book['book']->getId() ?>">
                            <input type="text" name="book_description" id="book_description" value="<?php echo $book['book']->getDescription() ?>" class="form-control">
                            <button type="submit">valider</button>
                        </form>
                    </td>
                    <td>
                        <form action="<?php echo REDIRECT_BASE_URL . "controller=admin&method=update" ?>" method="POST">
                            <input type="hidden" name="book_id" value="<?php echo $book['book']->getId() ?>">
                            <input type="text" name="book_price" id="book_price" value="<?php echo $book['book']->getPrice() ?>" class="form-control">
                            <button type="submit">valider</button>
                        </form>
                    </td>
                    <td>
                        <form action="<?php echo REDIRECT_BASE_URL . "controller=admin&method=update" ?>" method="POST">
                            <input type="hidden" name="book_id" value="<?php echo $book['book']->getId() ?>">
                            <input type="text" name="book_stock" id="book_stock" value="<?php echo $book['book']->getStock() ?>" class="form-control">
                            <button type="submit">valider</button>
                        </form>
                    </td>
                    <td>
                        <img src="<?php echo ABSOLUTE_ASSET_PATH . "/icons/action/attach_file_24px_rounded.svg" ?>" alt="atach file icon" class="attach-file">
                    </td>
                    <td>
                        <form action="<?php echo REDIRECT_BASE_URL . "controller=admin&method=destroy" ?>" method="POST">
                            <input type="hidden" name="book_id" value="<?php echo $book['book']->getId() ?>">
                            <button type="submit"><img src="<?php echo ABSOLUTE_ASSET_PATH . "/icons/action/Bucket_24px.svg" ?>" alt="delete product icon"></button>
                            <button type="submit">valider</button>
                        </form>
                    </td>
                    <td>
                        <p><?php echo $book['book']->getCreatedAtFormated() ?></p>
                    </td>
                    <td>
                        <p><?php echo $book['book']->getUpdatedAtFormated() ?></p>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>

    </table>


</div>