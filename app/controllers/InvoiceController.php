<?php


class InvoiceController extends ApplicationController
{
    public function show()
    {

        if (isset($_GET['id'])) {
            $invoice = Invoice::findInvoice($_GET['id'])[0];
            $this->render(
                "show",
                "La Nuit des temps: Mon profil, mes commandes",
                "Vos factures et commandes passées",
                array(
                    "invoice"=>$invoice
                )
            );
        }
    }
}
