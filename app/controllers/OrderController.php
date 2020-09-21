
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
                $datas = array();
                if( User::isUserSignedIn())
                {
                    header("Location:".REDIRECT_BASE_URL."controller=order&method=new&step=2");
                }
            } elseif ($_GET['step'] == "2") {
                $meta_title = "La Nuit des Temps: nouvelle commande - votre addresse";
                $meta_description = "2/3 Nouvelle commande: votre addresse";
                $user = User::getCurrentUser();
                $adresses = $user->getAdresses();
                $datas = array("adresses"=>$adresses);
                if (isset($_POST['confirm'], $_POST['user_address'], $_POST['user_city'], $_POST['user_postal_code'], $_POST['user_lastname'], $_POST['user_firstname'])) {
            
                    if (User::checkIfAdresseExists($_POST['user_address'], $user->getId())) {
                        $message = array("L'adresse spécifiée existe déjà");
                        $type = "info";
                    } else {
                        $user->updateDatas($_POST['user_firstname'], $_POST['user_lastname']);
                        $adress = $user->registerAdress($_POST['user_city'], $_POST['user_address'], $_POST['user_postal_code']);
                        $message = array("Votre adresse de livraison à bien été enregistrée");
                        $type = "success";
                        $step = "3";
                    }

                    if (isset($_POST['remote'])) {
                        echo json_encode(array("message" => $message, "type"=>$type));
                        die();
                    }

                    $flash = new Flash($message, $type);
                    $flash->storeInSession();
                    die(header("Location:" . REDIRECT_BASE_URL . "controller=order&method=new&step=" . $step));


                }elseif (isset($_POST["select_adresses"]))
                {
                    $adresses = $user->getAdresses();
                    if (isset($_POST['remote'])) {
                        echo json_encode(array("adresses"=>$adresses));
                        die();
                    }
                }
            } elseif ($_GET['step'] == "3" && isset($_POST['user_select_adress'])) {
                $adress = User::findAdress($_POST['user_select_adress'])[0];
                $meta_title = "La Nuit des Temps: nouvelle commande - paiement";
                $meta_description = "3/3 Nouvelle commande: paiement";
                $delivery_address = $adress['adress']." ".$adress['postal_code']." ".$adress['city'];
                $datas = array("delivery_address"=>$delivery_address);
            }
        }

        $this->render("index", $meta_title, $meta_description, $datas);
    }
}
