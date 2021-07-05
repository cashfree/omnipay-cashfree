# Omnipay: Cashfree

**Cashfree driver for the Omnipay PHP payment processing library**

[Omnipay](https://github.com/thephpleague/omnipay) is a framework agnostic,
multi-gateway payment processing library for PHP.
This package implements Cashfree support for Omnipay.
This version supports PHP ^5.6 and PHP ^7.

This is the `master` branch of Omnipay, handling Omnipay version `3.x`.

# Installation

Omnipay is installed via [Composer](http://getcomposer.org/).
To install, simply add it to your `composer.json` file:

```json
{
    "require": {
        "omnipay/cashfree": "~3.0"
    }
}
```

And run composer to update your dependencies:

    $ curl -s http://getcomposer.org/installer | php
    $ php composer.phar update

# Basic Usage

The following gateways are provided by this package:

* Cashfree_Checkout

For general Omnipay usage instructions, please see the main
[Omnipay](https://github.com/thephpleague/omnipay) repository.

# Supported Methods

## * Cashfree Checkout Method

Checkout Form is the simplest way to integrate Cashfree Payment Gateway in your website to accept payments quickly. In this integration method, you prepare the checkout form with the correct order and customer details and redirect users from your checkout page to Cashfree’s payment screen. Cashfree payment gateway supports all major payment methods such as credit and debit cards, wallets, UPI, and netbanking.

The Direct gateway methods for handling cards are:

* `purchase()` - with completePurchase for 3D Secure and cashfree redirect

### Direct Purchase

```php
use Omnipay\Omnipay;
use Omnipay\Common\CreditCard;

// Create the gateway object.

$gateway = GatewayFactory::create('Cashfree');

$response = $gateway->initialize($params);

// Create the credit card object from details entered by the user.

$card = new CreditCard([
    'firstName' => 'Card',
    'billingPhone' => '91********',

    // Billing address details are required.
    ...
]);

// Create the minimal request message.

$requestMessage = $gateway->purchase([
    'amount' => '99.99',
    'currency' => 'INR',
    'card' => $card,
    'transactionId' => $transactionId,
    'description' => 'Description here',
    'returnUrl' => 'https://example.co.uk/gateways/Cashfree/completePurchase',
    'returnUrl' => 'https://example.co.uk/gateways/Cashfree/acceptNotification',
]);

#### Redirect (3D Secure)

If the authorization result is a redirect, then a quick and dirty way to redirect is:


if ($response->isSuccessful()) {
    // The transaction is complete and successful and no further action is needed.
    // This may happen if a cardReference has been supplied, having captured
    // the card reference with a CVV and using it for the first time. The CVV will
    // only be kept by the gateway for this first authorization. This also assumes
    // 3D Secure is turned off.
} elseif ($response->isRedirect()) {
    // Redirect to offsite payment gateway to capture the users credit card
    // details.
    // If a cardReference was provided, then only the CVV will be asked for.
    // 3D Secure will be performed here too, if enabled.
    // Once the user is redirected to the gateway, the results will be POSTed
    // to the [notification handler](#sage-pay-server-notification-handler).
    // The handler will then inform the gateway where to finally return the user
    // to on the merchant site.

    $response->redirect();
} else {
    // Something went wrong; get the message.
    // The error may be a simple validation error on the address details.
    // Catch those and allow the user to correct the details and submit again.
    // This is a particular pain point of Sage Pay Server.
    $reason = $response->getMessage();
}
```

# Support

If you are having general issues with Omnipay, we suggest posting on
[Stack Overflow](http://stackoverflow.com/). Be sure to add the
[omnipay tag](http://stackoverflow.com/questions/tagged/omnipay) so it can be easily found.

If you want to keep up to date with release announcements, discuss ideas for the project,
or ask more detailed questions, there is also a [mailing list](https://groups.google.com/forum/#!forum/omnipay) which
you can subscribe to.

If you believe you have found a bug, please report it using the [GitHub issue tracker](https://github.com/cashfree/omnipay-cashfree/issues),
or better yet, fork the library and submit a pull request.