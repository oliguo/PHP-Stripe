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
                    <select class="sr-input sr-card-element" id="others-element">
                        <option value="alipay">AliPay</option>
                        <option value="wechat">WeChatPay</option>
                    </select>
                </div>
                <div class="sr-field-error" id="card-errors" role="alert"></div>
                <button id="submit">
                    <div class="spinner hidden" id="spinner"></div>
                    <span id="button-text">Pay</span>
                    <span id="order-amount"></span>
                </button>
            </form>
            <div class="sr-result hidden">
                <p id="result-title">Payment is ready to charge<br /></p>
                <pre>
            <code></code>
          </pre>
                <p class="redirect-url"></p>
            </div>
        </div>
    </div>
    <script src="./js/others.js" defer></script>
    <script type="text/javascript">
        <?php
        if (isset($_REQUEST['source'])) {
        ?>
            document.querySelector(".sr-payment-form").classList.add("hidden");
            document.querySelector("#result-title").innerHTML = "Payment completed";
            document.querySelector("pre").textContent = '<?php echo json_encode($_REQUEST) ?>';

            document.querySelector(".sr-result").classList.remove("hidden");
            setTimeout(function() {
                document.querySelector(".sr-result").classList.add("expand");
            }, 200);
        <?php
        }
        ?>
    </script>
</body>

</html>