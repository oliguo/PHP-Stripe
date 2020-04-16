// Handle form submission.
var form = document.getElementById("payment-form");
form.addEventListener("submit", function (event) {
  event.preventDefault();
  // Initiate payment when the submit button is clicked
  pay(stripe);
});


// Initiate the payment.
var pay = function (stripe) {
  changeLoadingState(true);
  var e = document.getElementById("others-element");
  var type = e.options[e.selectedIndex].value;
  if (type === 'alipay') {
    alipay(stripe);
  } else if (type === 'wechat') {
    wechat(stripe);
  } else {
    showError("Nothing");
  }

};

//AliPay
var alipay = function (stripe) {
  // https://stripe.com/docs/sources/alipay
  stripe.createSource({
    type: 'alipay',
    amount: 1000,
    currency: 'hkd',
    redirect: {
      return_url: 'http://localhost:5000/web/others.php',
    },
    owner: {
      email: "test@gmail.com",
      name: "Test name",
      phone: "+85255556666"
    },
    metadata: {
      order_id: '123456'
    }
  }).then(function (result) {
    // handle result.error or result.source
    if (result.error) {
      // Show error to your customer
      showError(result.error.message);
    } else {
      // The payment is chargeable and ask user to procced next!
      var redirect = result.source.redirect;
      var redirectJSON = JSON.stringify(redirect, null, 2);

      document.querySelector(".sr-payment-form").classList.add("hidden");
      document.querySelector("pre").textContent = redirectJSON;

      document.querySelector(".redirect-url").innerHTML = "Click to procced:<br/><br/><a href='" + result.source.redirect.url + "' target='_self' style='color:black;'>result.source.redirect.url</a>";

      document.querySelector(".sr-result").classList.remove("hidden");
      setTimeout(function () {
        document.querySelector(".sr-result").classList.add("expand");
      }, 200);

      changeLoadingState(false);
    }
  });
};
//WeChatPay
var wechat = function (stripe) {
  //https://stripe.com/docs/sources/wechat-pay
  stripe.createSource({
    type: 'wechat',
    amount: 1000,
    currency: 'hkd',
    statement_descriptor: 'ORDER AT11990',
    owner: {
      email: "test@gmail.com",
      name: "Test name",
      phone: "+85255556666"
    },
    metadata: {
      order_id: '123456'
    }
  }).then(function (result) {
    // handle result.error or result.source
    if (result.error) {
      // Show error to your customer
      showError(result.error.message);
    } else {
      // The payment is chargeable and ask user to procced next!
      var wechat = result.source.wechat;
      var wechatJSON = JSON.stringify(wechat, null, 2);

      document.querySelector(".sr-payment-form").classList.add("hidden");
      document.querySelector("pre").textContent = wechatJSON;

      document.querySelector(".redirect-url").innerHTML = "Click to procced:<br/><br/><a href='" + result.source.wechat.qr_code_url + "' target='_self' style='color:black;'>result.source.wechat.qr_code_url</a>";

      document.querySelector(".sr-result").classList.remove("hidden");
      setTimeout(function () {
        document.querySelector(".sr-result").classList.add("expand");
      }, 200);

      changeLoadingState(false);
    }
  });
};

/* ------- Post-payment helpers ------- */

/* Shows a success / error message when the payment is complete */

var showError = function (errorMsgText) {
  changeLoadingState(false);
  var errorMsg = document.querySelector(".sr-field-error");
  errorMsg.textContent = errorMsgText;
  setTimeout(function () {
    errorMsg.textContent = "";
  }, 4000);
};

// Show a spinner on payment submission
var changeLoadingState = function (isLoading) {
  if (isLoading) {
    document.querySelector("button").disabled = true;
    document.querySelector("#spinner").classList.remove("hidden");
    document.querySelector("#button-text").classList.add("hidden");
  } else {
    document.querySelector("button").disabled = false;
    document.querySelector("#spinner").classList.add("hidden");
    document.querySelector("#button-text").classList.remove("hidden");
  }
};