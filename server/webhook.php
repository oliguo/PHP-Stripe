<?php
require '../libs/core.php';
require '../vendor/autoload.php';

\Stripe\Stripe::setApiKey(STRIPE_SECRET_KEY);

$payload = @file_get_contents('php://input');
$sig_header = $_SERVER['HTTP_STRIPE_SIGNATURE'];
$event = null;

try {
    $event = \Stripe\Webhook::constructEvent(
        $payload, $sig_header, STRIPE_WEBHOOK_SECRET
    );
} catch(\UnexpectedValueException $e) {
    // Invalid payload
	http_response_code(400);
	echo json_encode(['error' => $e->getMessage()]);
    exit();
} catch(\Stripe\Exception\SignatureVerificationException $e) {
    // Invalid signature
	http_response_code(400);
	echo json_encode(['error' => $e->getMessage()]);
    exit();
}

// Handle the event
$details = '';
$output = [
	'status' => 'success',
	'details' => $details
];

if ($event->type == 'payment_intent.succeeded') {
	$output['details'] = '💰 Payment received!';
} else if ($event->type == 'payment_intent.payment_failed') {
	$output['details'] = '❌ Payment failed.';
} else if ($event->type == 'source.chargeable') {
	$output['details'] = 'source.chargeable';
	$charge = \Stripe\Charge::create([
		'amount' => 1000,
		'currency' => 'hkd',
		'source' => $event->data->object->id,
	]);
} else if ($event->type==='charge.succeeded') {
	$output['details'] = '💰 Payment received!';
} else if ($event->type==='source.failed') {
	$output['details'] = '❌ Payment failed.';
} else if ($event->type==='source.cancelled') {
	//https://stripe.com/docs/sources/alipay#settlement-currencies
	//https://stripe.com/docs/sources/wechat-pay#sources-expiration
	$output['details'] = '❌ Payment cancelled.';
} 



echo json_encode($output, JSON_PRETTY_PRINT);
