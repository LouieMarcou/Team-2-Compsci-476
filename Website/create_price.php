<?php

require_once('vendor/autoload.php');

   // Establish database connection
   include("pdo_connect.php");

 /* Check if the database connection is established. If not, exit the program. */
if (!$db) {
    echo "Could not connect to the database";
    exit();
}

$stripe = new \Stripe\StripeClient("sk_test_51M32h7CW4FUqp8zTkwPns6CMxp1eVC5m4kbCIPmevxQ8llDbBc8muDCRiizvn9168dXIBSvVhfnU1daWP5ZF8lsx00DQvuq3CW");

#$product = $stripe->products->create([
#  'name' => 'Donation',
#  'description' => '$12/Month subscription',
#]);
#echo "Success! Here is your starter subscription product id: " . $product->id . "\n";
#
#$price = $stripe->prices->create([
#  'unit_amount' => 120,
#  'currency' => 'usd',
#  'recurring' => ['interval' => 'month'],
#  'product' => $product['id'],
#]);
#prod_MrrGBM6MEZKY2G
echo "Success! Here is your premium subscription price id: " . $product->unit_amount . "\n";

?>