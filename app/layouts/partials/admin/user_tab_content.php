<div class="table-responsive" style="max-height:60vh;">
    <table id="admin-table" class="table table-borderless table-hover">
        <thead>
            <tr>
                <th id="email" scope="col">Email</th>
                <th id="lastname" scope="col">Nom</th>
                <th id="firstname" scope="col">Prenom</th>
                <th id="age" scope="col">Age</th>
                <th id="adresse" scope="col">Adresses</th>
            </tr>
        </thead>
        <tbody>

            <?php foreach ($users as $user) : ?>
                <tr id="user-<?php echo $user['user']->getId() ?>">

                    <td>
                        <form action="<?php echo REDIRECT_BASE_URL . "controller=admin&method=update" ?>" method="POST">
                            <input type="hidden" name="user_id" value="<?php echo $user['user']->getId() ?>">
                            <input type="email" class="form-control" value="<?php echo $user['user']->getEmail() ?>">
                        </form>
                    </td>
                    <td>
                        <form action="<?php echo REDIRECT_BASE_URL . "controller=admin&method=update" ?>" method="POST">
                            <input type="hidden" name="user_id" value="<?php echo $user['user']->getId() ?>">
                            <input type="text" class="form-control" value="<?php echo $user['user']->getLastname() ?>">
                        </form>
                    </td>

                    <td>
                        <form action="<?php echo REDIRECT_BASE_URL . "controller=admin&method=update" ?>" method="POST">
                            <input type="hidden" name="user_id" value="<?php echo $user['user']->getId() ?>">
                            <input type="text" class="form-control" value="<?php echo $user['user']->getFirstname() ?>">
                        </form>
                    </td>


                    <td>
                        <form action="<?php echo REDIRECT_BASE_URL . "controller=admin&method=update" ?>" method="POST">
                            <input type="hidden" name="user_id" value="<?php echo $user['user']->getId() ?>">
                            <input type="number" class="form-control" value="<?php echo $user['user']->getAge() ?>">
                        </form>
                    </td>

                    <td>

                        <form action="<?php echo REDIRECT_BASE_URL . "controller=admin&method=update" ?>" method="POST">
                            <input type="hidden" name="user_id" value="<?php echo $user['user']->getId() ?>">
                            <select name="" class="form-control">
                                <?php foreach ($user['adresses'] as $adress) : ?>
                                    <option value="<?php echo $adress['id'] ?>"><?php echo $adress['adress'] ?></option>
                                <?php endforeach; ?>
                            </select>
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
    Admin.getUserAcquisitionGraph()
</script>