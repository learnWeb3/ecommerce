<form action="" method="GET" class="my-4">
    <div class="form-row">
        <div class="col">
            <input type="search" name="search_input" id="search_input" class="form-control-lg col-12" placeholder="Rechercher par nom, prenom, email...">
        </div>
        <div class="col">
            <select name="search_filter" class="form-control-lg col-12">
                <option value="lastname">nom</option>
                <option value="firstname">prénom</option>
                <option value="email">email</option>
                <option value="admin">admin</option>
            </select>
        </div>
        <div class="col">
            <button type="submit" class="btn btn-lg btn-success">valider</button>
        </div>
    </div>
</form>



<div class="table-responsive" style="max-height:60vh;">
    <table id="admin-table-user" class="table table-borderless table-hover">
        <thead>
            <tr>
                <th id="email" scope="col">Email</th>
                <th id="lastname" scope="col">Nom</th>
                <th id="firstname" scope="col">Prenom</th>
                <th id="date-of-birth" scope="col">Date de naissance</th>
                <th id="adresse" scope="col">Adresses</th>
            </tr>
        </thead>
        <tbody>

            <?php foreach ($users as $user) : ?>
                <tr id="user-<?php echo $user['user']->getId() ?>">

                    <td>
                        <form action="<?php echo REDIRECT_BASE_URL . "controller=user&method=update" ?>" method="POST">
                            <input type="hidden" name="user_id" value="<?php echo $user['user']->getId() ?>">
                            <input type="email" class="form-control" value="<?php echo $user['user']->getEmail() ?>" name="user_email">
                        </form>
                    </td>
                    <td>
                        <form action="<?php echo REDIRECT_BASE_URL . "controller=user&method=update" ?>" method="POST">
                            <input type="hidden" name="user_id" value="<?php echo $user['user']->getId() ?>">
                            <input type="text" class="form-control" value="<?php echo $user['user']->getLastname() ?>" name="user_lastname">
                        </form>
                    </td>

                    <td>
                        <form action="<?php echo REDIRECT_BASE_URL . "controller=user&method=update" ?>" method="POST">
                            <input type="hidden" name="user_id" value="<?php echo $user['user']->getId() ?>">
                            <input type="text" class="form-control" value="<?php echo $user['user']->getFirstname() ?>" name="user_firstname">
                        </form>
                    </td>


                    <td>
                        <form action="<?php echo REDIRECT_BASE_URL . "controller=user&method=update" ?>" method="POST">
                            <input type="hidden" name="user_id" value="<?php echo $user['user']->getId() ?>">
                            <input type="date" class="form-control" value="<?php echo $user['user']->getDateOfBirth() ?>" name="user_date_of_birth">
                        </form>
                    </td>

                    <td>

                        <form action="<?php echo REDIRECT_BASE_URL . "controller=user&method=update" ?>" method="POST">
                            <input type="hidden" name="user_id" value="<?php echo $user['user']->getId() ?>">
                            <select name="user_adresses" class="form-control">
                                <?php foreach ($user['adresses'] as $adress) : ?>
                                    <option value="<?php echo $adress['id'] ?>"><?php echo $adress['adress'] ?></option>
                                <?php endforeach; ?>
                            </select>
                        </form>

                    </td>

                    <td>
                        <form action="<?php echo REDIRECT_BASE_URL . "controller=user&method=update" ?>" method="POST">
                            <input type="hidden" name="user_id" value="<?php echo $user['user']->getId() ?>">
                            <?php if ($user['user']->getAdmin()) : ?>

                                <div class="custom-control custom-radio custom-control-inline">
                                    <input type="radio" name="user_admin" id="admin<?php echo $user['user']->getId()?>-no" value="0" class="custom-control-input">
                                    <label class="custom-control-label" for="admin<?php echo $user['user']->getId()?>-no">Non</label>
                                </div>
                                <div class="custom-control custom-radio custom-control-inline">
                                    <input type="radio" name="user_admin" id="admin<?php echo $user['user']->getId()?>-yes" value="1" class="custom-control-input" checked>
                                    <label class="custom-control-label" for="admin<?php echo $user['user']->getId()?>-yes">Oui</label>
                                </div>
            
                            <?php else : ?>
                                <div class="custom-control custom-radio custom-control-inline">
                                    <input type="radio" name="user_admin" id="admin<?php echo $user['user']->getId()?>-no" value="0" class="custom-control-input" checked>
                                    <label class="custom-control-label" for="admin<?php echo $user['user']->getId()?>-no">Non</label>
                                </div>
                                <div class="custom-control custom-radio custom-control-inline">
                                    <input type="radio" name="user_admin" id="admin<?php echo $user['user']->getId()?>-yes" value="1" class="custom-control-input" >
                                    <label class="custom-control-label" for="admin<?php echo $user['user']->getId()?>-yes">Oui</label>
                                </div>
                            <?php endif; ?>
                        </form>
                    </td>


                    <td>
                        <form action="<?php echo REDIRECT_BASE_URL . "controller=user&method=destroy" ?>" method="POST" class="delete">
                            <input type="hidden" name="user_id" value="<?php echo $user['user']->getId() ?>">
                            <button type="submit" style="background-color:unset;border:none;"><img src="<?php echo ABSOLUTE_ASSET_PATH . "/icons/action/Bucket_24px.svg" ?>" alt="delete product icon"></button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>

    </table>

</div>



<div class="container-fluid">


    <div class="row">

        <div class="col-md-6 col-12" id="highchart-container-user">


        </div>

    </div>

    <div class="row">
        <div class="col-md-6 col-12">

            <table class="table">

                <thead>

                    <tr>
                        <th>Comptes crées (Jour)</th>
                        <th>Comptes crées (Mois)</th>
                        <th>Comptes crées (YTD)</th>
                    </tr>
                </thead>

                <tbody>

                    <tr>
                        <td><?php echo $user_account_creation_day ?></td>
                        <td><?php echo $user_account_creation_month ?></td>
                        <td><?php echo $user_account_creation_ytd ?></td>
                    </tr>

                </tbody>


            </table>

        </div>

    </div>


</div>


<script>
    Admin.getUserAcquisitionGraph();
   
    User.update();
</script>