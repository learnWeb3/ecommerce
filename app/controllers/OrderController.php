
<?php

class OrderController extends ApplicationController
{
    public function create()
    {
        if (isset($_POST['remote'])) {
        }
    }

    public function new()
    {
        if (isset($_GET['step'])) {
            if ($_GET['step'] == "1") {
                $meta_title = "La Nuit des Temps: nouvelle commande - connexion";
                $meta_description = "1/3 Nouvelle commande: identification";
            } elseif ($_GET['step'] == "2") {
                $meta_title = "La Nuit des Temps: nouvelle commande - votre addresse";
                $meta_description = "2/3 Nouvelle commande: votre addresse";
            } elseif ($_GET['step'] == "3") {
                $meta_title = "La Nuit des Temps: nouvelle commande - paiement";
                $meta_description = "3/3 Nouvelle commande: paiement";
            }
        }

        $this->render("index", $meta_title, $meta_description, array());
    }
}
