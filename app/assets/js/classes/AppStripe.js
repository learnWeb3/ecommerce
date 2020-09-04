class AppStripe {


    constructor() {
        this.stripePublishableKey = 'pk_test_51HKRyVBCSIgE2GxuO27KfzF7hek10vPdCAsNm1xy0MUemMPplqHD0QWGy2XCiIrfqu5zLka5ZuTo6ZViEMfVMHTz00XErL6cYA';
    }

    checkout(checkoutButton) {
        // MAKE A JS OBJECT WITH ALL OF THAT
        // Create an instance of the Stripe object with your publishable API key

        var stripe = Stripe(this.stripePublishableKey);
        // var checkoutButton = document.getElementById('stripe-checkout');

        var checkoutButton = $(checkoutButton)


        checkoutButton.click(function() {

            $.ajax({
                url: "/ecommerce/index.php?controller=checkout&method=create",
                type: "POST",
                data: "remote=true",
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