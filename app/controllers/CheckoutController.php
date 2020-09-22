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
            Session::storeStripeSession($stripe_session);

            // var_dump($session);
            echo json_encode($stripe_session);
        }
    }

    public function success()
    {
        $stripe_session = Session::retrieveStripeSession();
        $app_stripe = new AppStripe(STRIPE_SECRET_KEY);
        $stripe_session = $app_stripe->retrieveCheckoutSession($stripe_session->id);

        if ($stripe_session->payment_status == "paid")
        {
            // instance of order;
            $order = new Order();
            // instance of invoice// 
            $invoice = new Invoice()
        }
        //$this->render("success", "Achat réussi", "La Nuit des Temps vous confirme le succès de votre commande, nous faisons le maximum pour vous livrer dans les meilleurs délais");
    }

    public function error()
    {
        $this->render("error", "Une erreur est survenue", "Une erreur est survenu, veuillez contacter votre banque pour plus d'informations");
    }
}
