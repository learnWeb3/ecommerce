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
    public function createProduct($name)
    {
        $stripe = new \Stripe\StripeClient(
            $this->stripe_secret_key
        );

        // return object(Stripe\Product)
        return $stripe->products->create([
            'name' => $name,
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
    public function createSession(array $products)
    {
        $stripe = new \Stripe\StripeClient($this->stripe_secret_key);
        return $stripe->checkout->sessions->create([
            'success_url' => 'https://example.com/success',
            'cancel_url' => 'https://example.com/cancel',
            'payment_method_types' => ['card'],
            'line_items' =>$products,
            'mode' => 'payment',
        ]);
    }

}