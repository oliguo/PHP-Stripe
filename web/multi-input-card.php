<?php
require '../libs/core.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>Stripe Card Elements sample</title>
    <meta name="description" content="A demo of Stripe Payment Intents" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="icon" href="./img/favicon.ico" type="image/x-icon" />
    <link rel="stylesheet" href="./css/normalize.css" />
    <link rel="stylesheet" href="./css/global.css" />
    <script src="https://js.stripe.com/v3/"></script>
    <script type="text/javascript" defer>
        //https://stripe.com/docs/js/initializing
        //https://stripe.com/docs/js/appendix/supported_locales
        var stripe = Stripe('<?php echo STRIPE_PUBLISHABLE_KEY; ?>', {
            locale: 'en'
        });
    </script>
</head>

<body>
    <div class="sr-root">
        <div class="sr-main">
            <form id="payment-form" class="sr-payment-form">
                <div class="sr-combo-inputs-row">
                    <div class="sr-input sr-card-element" id="card-number-element"></div>
                </div>
                <br />
                <div class="sr-combo-inputs-row">
                    <div class="sr-input sr-card-element" id="card-expiry-element"></div>
                </div>
                <br />
                <div class="sr-combo-inputs-row">
                    <div class="sr-input sr-card-element" id="card-cvc-element"></div>
                </div>
                <br />
                <div class="sr-field-error" id="card-errors" role="alert"></div>
                <button id="submit">
                    <div class="spinner hidden" id="spinner"></div>
                    <span id="button-text">Pay</span>
                </button>
            </form>
            <div class="sr-result hidden">
                <p>Payment completed<br /></p>
                <pre>
            <code></code>
          </pre>
            </div>
        </div>
    </div>
    <script src="./js/multi-input-card.js" defer></script>
</body>

</html>