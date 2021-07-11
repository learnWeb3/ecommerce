<div class="container" id="container-invoice">

    <table id="invoice-table">
        <thead>
            <tr>
                <th colspan="5">
                    <h1>Facture N°<?php echo $invoice['invoice']->getId() ?></h1>
                </th>
            </tr>

            <tr>
                <th>A <?php echo $current_user->getFirstName() ?> <?php echo $current_user->getLastName() ?></th>
                <th colspan="2">Adresse de livraison : <?php echo $invoice['invoice']->getFullAdress() ?></th>
                <th colspan="2">Payé par: <?php echo $invoice['invoice']->getCardType() ?> N° <?php echo $invoice['invoice']->getCardDetailsNumber() ?> - <?php echo $invoice['invoice']->getCardDetailsExpDate() ?> </th>
            </tr>

            <tr>
                <th>Image</th>
                <th>Designation</th>
                <th>Prix HT</th>
                <th>Prix TTC</th>
                <th>Quantité</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($invoice['invoice']->getItems() as $item) : ?>
                <tr>
                    <td><img src="<?php echo $item->getBook()->getImagePath() ?>" alt="<?php echo $item->getBook()->getTitle() ?> cover>"></td>
                    <td><a href="<?php echo REDIRECT_BASE_URL . "controller=book&method=show&id=" . $item->getBook()->getId() ?>"><?php echo $item->getBook()->getTitle() ?></a></td>
                    <td><?php echo $item->getBook()->getHtPrice() ?> &euro;</td>
                    <td><?php echo $item->getBook()->getPrice() ?> &euro;</td>
                    <td><?php echo $item->getQuantity() ?></td>
                </tr>
            <?php endforeach; ?>

        </tbody>

        <tfoot>
            <tr>
                <td colspan="3"></td>
                <td>TOTAL HT: <strong><?php echo $invoice['invoice']->getTotalAmountHT() ?> &euro;</strong></td>
                <td>TOTAL TTC: <strong><?php echo $invoice['invoice']->getTotalAmountTTC() ?> &euro;</strong></td>
            </tr>
        </tfoot>
    </table>

</div>