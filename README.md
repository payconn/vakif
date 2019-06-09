# Vakıf

**Vakif (Vpos724) gateway for Payconn payment processing library**

[![Build Status](https://travis-ci.com/payconn/vakif.svg?branch=master)](https://travis-ci.com/payconn/vakif)

[Payconn](https://github.com/payconn/common) is a framework agnostic, multi-gateway payment
processing library for PHP. This package implements common classes required by Payconn.

## Installation

    composer require payconn/vakif:~1.0.0

## Supported banks
* Vakıf
* Yapı Kredi 

## Supported methods
* purchase
* authorize
* complete
* refund
* cancel

## Basic Usage
```php
use Payconn\Common\CreditCard;
use Payconn\Vakif\Token;
use Payconn\Vakif\Model\Purchase;
use Payconn\Vakif\Currency;
use Payconn\Vakif;

$token = new Token('000100000013506', 'VP000579', '123456');
$purchase = new Purchase();
$purchase->setTestMode(true);
$purchase->setCurrency(Currency::TRY);
$purchase->setAmount(100);
$purchase->setInstallment(1);
$purchase->setCreditCard(new CreditCard('4289450189088488', '2023', '04', '060'));
$response = (new Vakif($token))->purchase($purchase);
if($response->isSuccessful()){
    // success!
}
```

## Change log

Please see [UPGRADE](UPGRADE.md) for more information on how to upgrade to the latest version.

## Support

If you are having general issues with Payconn, we suggest posting on
[Stack Overflow](http://stackoverflow.com/). Be sure to add the

If you believe you have found a bug, please report it using the [GitHub issue tracker](https://github.com/payconn/vakif/issues),
or better yet, fork the library and submit a pull request.


## Security

If you discover any security related issues, please email muratsac@mail.com instead of using the issue tracker.


## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
