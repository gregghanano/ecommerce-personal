<?php
require_once('/application/libraries/lib/Stripe.php');

$stripe = array(
  "secret_key"      => "sk_test_LUm2o3niYvmaqKK2AnC30yFT",
  "publishable_key" => "pk_test_S8bMKedY4rWzwI0NWZFfEeZk"
);

Stripe::setApiKey($stripe['secret_key']);
?>