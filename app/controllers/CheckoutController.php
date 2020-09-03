<?php

class CheckoutController
{
    public function create()
    {
        if (isset($_POST['remote'])) {
            $stripe = new AppStripe(STRIPE_SECRET_KEY);
            $products = Basket::getBasket()->checkout();
            // creating a checkout session
            $session = $stripe->createSession($products);
            echo json_encode($session);
        }
    }
}
