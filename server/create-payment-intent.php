<?php

require '../libs/core.php';
require '../vendor/autoload.php';

\Stripe\Stripe::setApiKey(STRIPE_SECRET_KEY);

$input = file_get_contents('php://input');
$body = json_decode($input);

if ($_SERVER['REQUEST_METHOD'] !== 'POST' || json_last_error() !== JSON_ERROR_NONE) {
	http_response_code(400);
	echo json_encode([ 'error' => 'Invalid request.' ]);
	exit;
}

$paymentIntent = \Stripe\PaymentIntent::create([
	'amount' => $body->amount,
	'currency' => $body->currency,
]);

$output = [
	'publishableKey' => STRIPE_PUBLISHABLE_KEY,
	'clientSecret' => $paymentIntent->client_secret,
];

echo json_encode($output);
