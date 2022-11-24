<?php

require_once('vendor/autoload.php');

$stripe = new \Stripe\StripeClient("sk_test_51M32h7CW4FUqp8zTkwPns6CMxp1eVC5m4kbCIPmevxQ8llDbBc8muDCRiizvn9168dXIBSvVhfnU1daWP5ZF8lsx00DQvuq3CW");

$product = $stripe->products->create([
  'name' => 'Starter Subscription',
  'description' => '$12/Month subscription',
]);
echo "Success! Here is your starter subscription product id: " . $product->id . "\n";

$price = $stripe->prices->create([
  'unit_amount' => 120,
  'currency' => 'usd',
  'recurring' => ['interval' => 'month'],
  'product' => $product['id'],
]);
echo "Success! Here is your premium subscription price id: " . $price->unit_amount . "\n";

?>