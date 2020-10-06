<form action="" method="post" class="my-4">
    <div class="form-row">
        <div class="col">
            <input type="search" name="search_input" id="search_input" class="form-control-lg col-12" placeholder="Rechercher par titre,auteur,collection,catégorie,description...">
        </div>
        <div class="col">
            <select name="search_filter" class="form-control-lg col-12">
                <?php foreach ($search_filters as $search_filter) : ?>
                    <option value="<?php echo $search_filter['filter'] ?>"><?php echo $search_filter['filter_name'] ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="col">
        <button type="submit" class="btn btn-lg btn-success">valider</button>
        </div>
    </div>
</form>


<div class="table-responsive" style="max-height:60vh;">
    <table id="admin-table" class="table table-borderless table-hover">
        <thead>
            <tr>
                <th id="image" scope="col">Image</th>
                <th id="book_category" scope="col">Catégorie<img src="<?php echo ABSOLUTE_ASSET_PATH?>/icons/action/sort_down.svg" alt="sort down" class="sort-arrow ml-2" data="desc"></th>
                <th id="book_tva" scope="col">Tva<img src="<?php echo ABSOLUTE_ASSET_PATH?>/icons/action/sort_down.svg" alt="sort down" class="sort-arrow ml-2" data="desc"></th>
                <th id="book_image_url" scope="col">Image url<img src="<?php echo ABSOLUTE_ASSET_PATH?>/icons/action/sort_down.svg" alt="sort down" class="sort-arrow ml-2" data="desc"></th>
                <th id="book_title" scope="col">Titre<img src="<?php echo ABSOLUTE_ASSET_PATH?>/icons/action/sort_down.svg" alt="sort down" class="sort-arrow ml-2" data="desc"></th>
                <th id="book_author" scope="col">Auteur<img src="<?php echo ABSOLUTE_ASSET_PATH?>/icons/action/sort_down.svg" alt="sort down" class="sort-arrow ml-2" data="desc"></th>
                <th id="book_collection" scope="col">Collection<img src="<?php echo ABSOLUTE_ASSET_PATH?>/icons/action/sort_down.svg" alt="sort down" class="sort-arrow ml-2" data="desc"></th>
                <th id="book_description" scope="col">Description<img src="<?php echo ABSOLUTE_ASSET_PATH?>/icons/action/sort_down.svg" alt="sort down" class="sort-arrow ml-2" data="desc"></th>
                <th id="book_price" scope="col">Prix<img src="<?php echo ABSOLUTE_ASSET_PATH?>/icons/action/sort_down.svg" alt="sort down" class="sort-arrow ml-2" data="desc"></th>
                <th id="book_stock" scope="col">Stock<img src="<?php echo ABSOLUTE_ASSET_PATH?>/icons/action/sort_down.svg" alt="sort down" class="sort-arrow ml-2" data="desc"></th>
                <th id="upload" scope="col">Upload</th>
                <th id="delete" scope="col">Supprimer</th>
                <th id="book_created_at" scope="col">Crée à<img src="<?php echo ABSOLUTE_ASSET_PATH?>/icons/action/sort_down.svg" alt="sort down" class="sort-arrow ml-2" data="desc"></th>
                <th id="book_updated_at" scope="col">Mis à jour à<img src="<?php echo ABSOLUTE_ASSET_PATH?>/icons/action/sort_down.svg" alt="sort down" class="sort-arrow ml-2" data="desc"></th>
            </tr>
        </thead>
        <tbody>

            <?php foreach ($books as $book) : ?>
                <tr id="book-<?php echo $book['book']->getId() ?>">
                    <td>
                        <img src="<?php echo $book['book']->getImagePath() ?>" alt="<?php echo $book['book']->getTitle() . " " . "poster" ?>" style="height:8rem;width:5rem;">
                    </td>
                    <td>
                        <form action="<?php echo REDIRECT_BASE_URL . "controller=admin&method=update" ?>" method="POST">
                            <input type="hidden" name="book_id" value="<?php echo $book['book']->getId() ?>">
                            <select name="book_category_id" class="form-control">
                                <?php foreach ($categories as $category) : ?>
                                    <?php if ($category->getId() == $book['book']->getCategoryId()) : ?>
                                        <option value="<?php echo $category->getId() ?>" selected><?php echo $category->getName() ?></option>
                                    <?php else : ?>
                                        <option value="<?php echo $category->getId() ?>"><?php echo $category->getName() ?></option>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            </select>
                           
                        </form>
                    </td>
                    <td>
                        <form action="<?php echo REDIRECT_BASE_URL . "controller=admin&method=update" ?>" method="POST">
                            <input type="hidden" name="book_id" value="<?php echo $book['book']->getId() ?>">
                            <select name="book_tva_id" class="form-control">
                                <?php foreach ($tva_types as $tva) : ?>
                                    <option value="<?php echo $tva['id'] ?>"><?php echo $tva['code'] ?></option>
                                <?php endforeach; ?>
                            </select>
                           
                        </form>
                    </td>
                    <td>
                        <form action="<?php echo REDIRECT_BASE_URL . "controller=admin&method=update" ?>" method="POST">
                            <input type="hidden" name="book_id" value="<?php echo $book['book']->getId() ?>">
                            <input type="text" name="book_image_path" value="<?php echo $book['book']->getImagePath() ?>"  class="form-control">
                           
                        </form>
                    </td>
                    <td>
                        <form action="<?php echo REDIRECT_BASE_URL . "controller=admin&method=update" ?>" method="POST">
                            <input type="hidden" name="book_id" value="<?php echo $book['book']->getId() ?>">
                            <input type="text" name="book_title" value="<?php echo $book['book']->getTitle() ?>"  class="form-control">
                           
                        </form>
                    </td>
                    <td>
                        <form action="<?php echo REDIRECT_BASE_URL . "controller=admin&method=update" ?>" method="POST">
                            <input type="hidden" name="book_id" value="<?php echo $book['book']->getId() ?>">
                            <input type="text" name="book_author" value="<?php echo $book['book']->getAuthor() ?>"  class="form-control">
                           
                        </form>
                    </td>
                    <td>
                        <form action="<?php echo REDIRECT_BASE_URL . "controller=admin&method=update" ?>" method="POST">
                            <input type="hidden" name="book_id" value="<?php echo $book['book']->getId() ?>">
                            <input type="text" name="book_collection" value="<?php echo $book['book']->getCollection() ?>"  class="form-control">
                           
                        </form>
                    </td>
                    <td>
                        <form action="<?php echo REDIRECT_BASE_URL . "controller=admin&method=update" ?>" method="POST">
                            <input type="hidden" name="book_id" value="<?php echo $book['book']->getId() ?>">
                            <input type="text" name="book_description" value="<?php echo $book['book']->getDescription() ?>" class="form-control">
                           
                        </form>
                    </td>
                    <td>
                        <form action="<?php echo REDIRECT_BASE_URL . "controller=admin&method=update" ?>" method="POST">
                            <input type="hidden" name="book_id" value="<?php echo $book['book']->getId() ?>">
                            <input type="text" name="book_price"  value="<?php echo $book['book']->getPrice() ?>" class="form-control">
                           
                        </form>
                    </td>
                    <td>
                        <form action="<?php echo REDIRECT_BASE_URL . "controller=admin&method=update" ?>" method="POST">
                            <input type="hidden" name="book_id" value="<?php echo $book['book']->getId() ?>">
                            <input type="text" name="book_stock" value="<?php echo $book['book']->getStock() ?>" class="form-control">
                           
                        </form>
                    </td>
                    <td>
                        <form action="<?php echo REDIRECT_BASE_URL . "controller=admin&method=destroy" ?>" method="POST" class="delete">
                            <input type="hidden" name="book_id" value="<?php echo $book['book']->getId() ?>">
                            <button type="submit" style="background-color:unset;border:none;"><img src="<?php echo ABSOLUTE_ASSET_PATH . "/icons/action/Bucket_24px.svg" ?>" alt="delete product icon"></button>
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