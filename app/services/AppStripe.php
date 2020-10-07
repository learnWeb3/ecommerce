<?php

use Stripe\Stripe;

class AppStripe
{

    // attribute of own stripe class to use it in below functions
    private $stripe_secret_key;


    // constructor function passing the global variables set with credentials when instanciation of object is made
    public function __construct($stripe_secret_key)
    {
        $this->stripe_secret_key = $stripe_secret_key;
    }

    // creating product object 
    // $product = $stripe->getProduct($_POST["products"]);
    // constructing product on the Stripe server
    public function createProduct(string $name, string $description, array $images)
    {
        $stripe = new \Stripe\StripeClient(
            $this->stripe_secret_key
        );

        // return object(Stripe\Product)
        return $stripe->products->create([
            'name' => $name,
            "description" => $description,
            "images" => $images,
        ]);
    }

    // constructing price on the stripe server using the Product id of the Stripe\Product Object previously constructed
    // creating price object 
    // $price = $stripe->createPrice($product->id, ceil($_POST["price"] * 100));
    public function createPrice($product_id, $unit_amount, $currency_symbol = 'eur')
    {
        $stripe = new \Stripe\StripeClient(
            $this->stripe_secret_key
        );
        // return object(Stripe\Price)
        return $stripe->prices->create([
            'unit_amount' => $unit_amount,
            'currency' => $currency_symbol,
            'product' => $product_id,
        ]);
    }

    // creating a checkout session passing price id of the Stripe\Price Object previously constructed
    //  $products =[
    // [
    //     'price' => $price_id,
    //     'quantity' => $quantity,
    //   ],
    // ]
    public function createSession(array $products, array $payment_methods = ['card'], string  $success_url = STRIPE_SUCCESS_URL, string $cancel_url = STRIPE_CANCEL_URL)
    {
        $stripe = new \Stripe\StripeClient($this->stripe_secret_key);
        return $stripe->checkout->sessions->create([
            'success_url' => $success_url,
            'cancel_url' => $cancel_url,
            'payment_method_types' => $payment_methods,
            'line_items' => $products,
            'mode' => 'payment',
        ]);
    }


    // UPDATE STRIPE PRODUCT ATTRIBUTES ON STRIPE 
    public function updateProduct(string $stripe_product_id, string $product_name, string $product_description, array $images = [])
    {
        $stripe = new \Stripe\StripeClient(
            $this->stripe_secret_key
        );
        return  $stripe->products->update(
            $stripe_product_id,
            array(
                "name" => $product_name,
                "description" => $product_description,
                "images" => $images
            )
        );
    }


    // UPDATE STRIPE PRICE ATTRIBUTES ON STRIPE
    public function updatePrice(string $stripe_price_id)
    {
        $stripe = new \Stripe\StripeClient(
            $this->stripe_secret_key
        );
        $stripe->prices->update(
            $stripe_price_id,
            ['active'=>false]
        );
    }




    // RETRIEVE A CHECKOUT SESSION BY ID

    public function retrieveCheckoutSession($stripe_checkout_session_id)
    {
        $stripe = new \Stripe\StripeClient(
            $this->stripe_secret_key
        );
        return $stripe->checkout->sessions->retrieve($stripe_checkout_session_id);
    }


    // RETRIEVE PAYMENT INTENT 

    public function retrievePaymentIntent($payment_intent_id)
    {
        $stripe = new \Stripe\StripeClient(
            $this->stripe_secret_key
        );
        return $stripe->paymentIntents->retrieve(
            $payment_intent_id
          );
    }



}
