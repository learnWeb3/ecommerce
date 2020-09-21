
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
                if (isset($_POST['confirm'], $_POST['user_address'], $_POST['user_city'], $_POST['user_postal_code'], $_POST['user_lastname'], $_POST['user_firstname'])) {
                    $user = User::getCurrentUser();
                    $user->updateDatas($_POST['user_firstname'], $_POST['user_lastname']);
                    $adress = $user->registerAdress($_POST['user_city'], $_POST['user_address'], $_POST['user_postal_code']);
                    Session::storeAddress($adress);
                    $message = array("Votre adresse de livraison à bien été enregistrée");
                    $type = "success";
                    $step = "3";

                    if (isset($_POST['remote'])) {
                        echo json_encode(array("message" => $message));
                        die();
                    }

                    $flash = new Flash($message, $type);
                    $flash->storeInSession();
                    die(header("Location:" . REDIRECT_BASE_URL . "controller=order&method=new&step=" . $step));

                }
               
            } elseif ($_GET['step'] == "3") {
                $meta_title = "La Nuit des Temps: nouvelle commande - paiement";
                $meta_description = "3/3 Nouvelle commande: paiement";
            }
        }
        $this->render("index", $meta_title, $meta_description, array());
    }
}
