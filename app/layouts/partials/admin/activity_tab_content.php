<div class="container-fluid">


    <div class="row" style="min-height:100vh">


        <div class="col-12 col-md-6 d-flex flex-column justify-content-center">

            <div class="container-fluid">

                <h1>Votre activité:</h1>

                <hr class="my-4">


                <h2>Chiffres clés</h2>

                
                <table class="table">

                    <thead>

                        <tr>
                            <th>CA Jour</th>
                            <th>CA Mensuel</th>
                            <th>CA YTD</th>
                        </tr>
                    </thead>

                    <tbody>

                        <tr>
                            <td><?php ?></td>
                            <td><?php ?></td>
                            <td><?php ?></td>
                        </tr>

                    </tbody>


                </table>


                <hr class="my-4">


                <h2>Nombre d'articles en stock</h2>


                <h3><?php echo $total_stock['total_stock'] ?> articles en stocks pour <?php echo $total_stock['total_product_number'] ?> items </h3>


                <hr class="my-4">


                <h2>Ajouter un article</h2>

                <button class="btn btn-lg btn-success" id="add-article">ajouter</button>


                <hr class="my-4">




                <form action="<?php REDIRECT_BASE_URL . "controller=category&method=create" ?>" method="post">

                    <h2>Créer une catégorie</h2>

                    <div class="form-group">

                        <label for="category_name">Nom de la cétgorie</label>

                        <input type="text" class="form-control" name="category_name" id="category_name" placeholder="Arts et loisirs créatifs">

                    </div>


                    <button type="submit" class="btn btn-lg btn-success">valider</button>


                </form>





            </div>


        </div>
        <div class="col-12 col-md-6" id="highchart-container">






        </div>



    </div>


</div>

<script>
    $("#add-article").click((e) => {
        $("#product-create-tab").click();
    });

    Admin. getCategoriesRepartition();
</script>