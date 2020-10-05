
<?php if (isset($_SESSION['flash'])) : ?>

    <div class="alert alert-<?php echo Flash::getFlash()->getType() ?> alert-dismissible fade show m-0 fixed-bottom" role="alert">
        <div class="w-100 d-flex justify-content-center align-items-center flex-column">
            <?php foreach (Flash::getFlash()->getMessages() as $message) : ?>
                <p class="p-0 m-0"><?php echo $message ?></p>
            <?php endforeach ?>
        </div>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <?php Flash::removeFlash() ?>
    
<?php endif; ?>