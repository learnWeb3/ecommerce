$(document).ready(function() {
    Checkout.signUpToggle();
    Session.create("#sign-in", "#sign-in-container", true);
    Checkout.confirmAdress("#adress-confirmation");
    // CALLING AJAX FUNTION TO FETCH RESULT OF STRIPE SCRIPT
    const stripeSecret = "<?php echo STRIPE_PUBLISHABLE_KEY ?>";
    const appStripe = new AppStripe();
    appStripe.checkout("#stripe-checkout");
});