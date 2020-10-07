<?php

define(
    "STRIPE_PUBLISHABLE_KEY",
    'pk_test_51HKRyVBCSIgE2GxuO27KfzF7hek10vPdCAsNm1xy0MUemMPplqHD0QWGy2XCiIrfqu5zLka5ZuTo6ZViEMfVMHTz00XErL6cYA'
);
define(
    "STRIPE_SECRET_KEY",
    "sk_test_51HKRyVBCSIgE2Gxu1J5IqjK3yh4Wq4nlVmAY8ywa8AO7dRPaW4RsLD7l2tQHgkD95IsBWSzuLsLO1A5CwIOLKPCZ00dyq8AlUX"
);
if ($_SERVER['DOCUMENT_ROOT'] == '/var/www/boutiqueenligne') {
    define(
        "STRIPE_SUCCESS_URL",
        "http://" . $_SERVER['SERVER_NAME'] . "/index.php?controller=checkout&method=success"
    );
    define(
        "STRIPE_CANCEL_URL",
        "http://" . $_SERVER['SERVER_NAME'] . "/index.php?controller=checkout&method=error"
    );
} else {
    define(
        "STRIPE_SUCCESS_URL",
        "http://" . $_SERVER['SERVER_NAME'] . "/ecommerce/index.php?controller=checkout&method=success"
    );
    define(
        "STRIPE_CANCEL_URL",
        "http://" . $_SERVER['SERVER_NAME'] . "/ecommerce/index.php?controller=checkout&method=error"
    );
}
