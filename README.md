# PHP-Stripe
```
The repo to build up a demo flow how to use the Stripe API for integration.
```

## API Docs
```
https://stripe.com/docs/js
https://stripe.com/docs/sources
https://stripe.com/docs/api/sources/create
https://stripe.com/docs/webhooks
https://stripe.com/docs/testing#cards
```

## Ngrok tool
```
We need for test under HTTPS and receive the event from Webhook

https://ngrok.com/
```

## Run the demo

### Git clone the project
```
$ git clone https://github.com/oliguo/PHP-Stripe.git
```

### Run composer to install the 'Stripe' SDK
```
$ composer install
```

### Go to modify the keys on the 'libs/core.php'
```php
/**
 * Get the 'STRIPE_SECRET_KEY' and 'STRIPE_PUBLISHABLE_KEY' from
 * https://dashboard.stripe.com/test/apikeys After you login
 * 
 * Get the 'STRIPE_WEBHOOK_SECRET' from
 * https://dashboard.stripe.com/test/webhooks After you login
 */
define("STRIPE_SECRET_KEY","sk_test_xxx");
define("STRIPE_PUBLISHABLE_KEY","pk_test_xxx");
define("STRIPE_WEBHOOK_SECRET","whsec_xxx");
```

### Run the PHP program
```
$ php -S localhost:5000
```

### Run the your ngrok program
```
$ ngrok http 5000
```

### Copy the external url from ngrok to the webhook settng of Stripe console
```
https://dashboard.stripe.com/test/webhooks
```

## Access the pages

### One input card
```
http://localhost:5000/web/one-input-card.php
```
<img src="https://github.com/oliguo/PHP-Stripe/blob/master/screenshots/one-input-card.gif" width="250"/>

### Multi input card
```
http://localhost:5000/web/multi-input-card.php
```
<img src="https://github.com/oliguo/PHP-Stripe/blob/master/screenshots/multi-input-card.gif" width="250"/>

###  Other(AliPay, WeChatPay)
```
http://localhost:5000/web/others.php
```
<img src="https://github.com/oliguo/PHP-Stripe/blob/master/screenshots/others-alipay.gif" width="250"/>

<img src="https://github.com/oliguo/PHP-Stripe/blob/master/screenshots/others-wechat-pay.gif" width="250"/>

### To limit specify card
```js
   /**
   * If you would like to handle card, e.g.Limit only visa
   * https://stripe.com/docs/js/element/events/on_change?type=cardElement
   */
  card.on('change', function (event) {
    if (event.error) {
      // show validation to customer
    }
    var displayError = document.getElementById('card-errors');
    if (event.brand === 'visa') {
      // to do the logic
      displayError.textContent = '';
    } else {
      displayError.textContent = 'only visa';
    }
  });
```
<img src="https://github.com/oliguo/PHP-Stripe/blob/master/screenshots/only-visa-one-input.png" width="250"/>

<img src="https://github.com/oliguo/PHP-Stripe/blob/master/screenshots/only-visa-multi-input.png" width="250"/>


