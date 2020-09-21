<?php

class CheckoutController extends ApplicationController
{
    public function create()
    {
        if (isset($_POST['remote'])) {
            $stripe = new AppStripe(STRIPE_SECRET_KEY);
            $products = Basket::getBasket()->checkout();
            // creating a checkout session
            $stripe_session = $stripe->createSession($products);
            
            // storing stripe session to check later payment status and instantialte order
            $_SESSION['stripe_checkout'] = $stripe_session;

            // var_dump($session);
            echo json_encode($stripe_session);
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
}
