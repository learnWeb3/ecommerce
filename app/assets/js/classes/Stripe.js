class Stripe {

    static checkout(checkoutButton, stripeSecret, basketItems = []) {
        // MAKE A JS OBJECT WITH ALL OF THAT
        // Create an instance of the Stripe object with your publishable API key

        var stripe = Stripe(stripeSecret);
        // var checkoutButton = document.getElementById('stripe-checkout');

        var checkoutButton = $(checkoutButton)


        checkoutButton.click(function() {

            $.ajax({
                url: "Stripe.php",
                type: "POST",
                data: "stripe_checkout=true",
                dataType: "JSON",
                success: function(result, status) {
                    if (result.error) {
                        alert(result.error.message);
                    } else {

                        return stripe.redirectToCheckout({
                            sessionId: result.id
                        });
                    }

                },
                error: function(results, status, error) {
                    console.log(error)
                },
                complete: function(result, status) {},
            });

        });
    }
}