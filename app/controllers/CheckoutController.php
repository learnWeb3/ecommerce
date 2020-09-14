<?php

class CheckoutController extends ApplicationController
{
    public function create()
    {
        if (isset($_POST['remote'])) {
            $stripe = new AppStripe(STRIPE_SECRET_KEY);
            $products = Basket::getBasket()->checkout();
            // creating a checkout session
            $session = $stripe->createSession($products);

            // var_dump($session);
            echo json_encode($session);
        }
    }

    public function success()
    {
        $this->render("success", "Achat réussi", "La Nuit des Temps vous confirme le succès de votre commande, nous faisons le maximum pour vous livrer dans les meilleurs délais");
    }

    public function error()
    {
        $this->render("error", "Une erreur est survenue", "Une erreur est survenu, veuillez contacter votre banque pour plus d'informations");
    }

    public function new()
    {
        if (isset($_POST['remote'])) {
            if (isset($_SESSION['current_user'])) {
                if (isset($_SESSION['delivery_address'])) {
                    // echo "<buttton class=\"btn btn-lg btn-success my-4\" id=\"stripe-checkout\">Payer</buttton>";
                    $action_type = "payment";
                } else {
                    $action_type = "delivery_details";
                }
            } else {
                $action_type = "sign_actions";
            }

            echo json_encode(array("action_type"=>$action_type));
        }
    }
}
