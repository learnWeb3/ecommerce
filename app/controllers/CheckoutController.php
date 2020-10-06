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

            $payment_intent_id = $stripe_session->payment_intent;
            // retriving current user from session
            $user = User::getCurrentUser();
            // retireving basket from session
            $basket = Basket::getCurrentBasket($user->getId())[0];
            $basket->setBasketItems(Basket::getBasket()->getBasketItems());
            // updating basket content in database
            $user->updateBasketItems($basket->getAllProducts());
            // updating basket state
            $adress_id = $_SESSION['selected_adress_id'];
            // instance of invoice// 
            $invoice = new Invoice($basket->getId(), $basket->getTotalTTC(), $basket->getTotalHT(), $adress_id, $payment_intent_id);
            $invoice->create();
            $basket->updateBasketState();
            Session::destroyBasket();

            $mailer = new Mailer($user->getEmail(), "Votre commande:", LAYOUT_PATH."/mailer/welcome_send.php");
            $mailer->send(array("invoice"=>$invoice));
                
            $this->render("success", "Achat réussi", "La Nuit des Temps vous confirme le succès de votre commande, nous faisons le maximum pour vous livrer dans les meilleurs délais");
        }else{
            header("Location:".REDIRECT_BASE_URL."controller=checkout&method=error");
        }
    }

    public function error()
    {
        $this->render("error", "Une erreur est survenue", "Une erreur est survenu, veuillez contacter votre banque pour plus d'informations");
    }
}
