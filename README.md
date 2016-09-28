# Paylike PHP Api Wrapper

This is the PHP wrapper for the paylike [sdk](https://github.com/paylike/sdk)

[Sign up for a free merchant account (free and instant)](https://paylike.io)

- Table of contents
	- [Getting an API key](#getting-an-api-key)
	- [Requirements](#requirements)
	- [Examples](#examples)
	- [Getting started](#getting-started)
	- [Capturing a transaction](#capturing-a-transaction)
	- [Authorizing a transaction](#authorizing-a-transaction)
	- [Refund a transaction](#refund-a-transaction)
	- [Void a transaction](#void-a-transaction)
	- [Fetch a transaction](#fetch-a-transaction)

## Getting an API key

An API key can be obtained by creating a merchant and adding an app through
our [dashboard](https://app.paylike.io). 

## Requirements

PHP 5.3.3 and later.

## Examples

Examples are available in the `examples.php` file. 

## Getting started

Download the latest release and include the `Client.php` file in your `php` application. 

```php
require_once('/path/to/Paylike/Client.php');
$private_app_key = 'your-private-key-goes-here';
\Paylike\Client::setKey( $private_app_key );
```


## Capturing a transaction
**Every operation requires a transaction id that is obtained by using the javscript [sdk](https://github.com/paylike/sdk).**

```php

	//$amount is the cent value.
	//$currency see available formats https://github.com/paylike/currencies
	$transaction = \Paylike\Transaction::capture( $transaction_id, $amount, $currency );
	// you will now have the transaction data in the $transaction variable.
	
```


## Authorizing a transaction
**Every operation requires a transaction id that is obtained by using the javscript [sdk](https://github.com/paylike/sdk).**

Transactions are authorized via the client side, so having a transaction id means it has been authorized. You do not need to do anything to authorize the transaction but you can fetch it in order to see its state.

```php
	$transaction = \Paylike\Transaction::fetch( $transaction_id);
	// you will now have the transaction data in the $transaction variable.
```


## Refund a transaction
**Every operation requires a transaction id that is obtained by using the javscript [sdk](https://github.com/paylike/sdk).**


```php
	//$amount is the cent value.
	//$reason is optional see https://github.com/paylike/descriptor for format and restrictions.
	$transaction = \Paylike\Transaction::refund( $transaction_id, $amount,$reason );
	// you will now have the transaction data in the $transaction variable.
```

## Void a transaction
**Every operation requires a transaction id that is obtained by using the javscript [sdk](https://github.com/paylike/sdk).**


```php
	//$amount is the cent value.
	$transaction = \Paylike\Transaction::void( $transaction_id, $amount);
	// you will now have the transaction data in the $transaction variable.
```

## Fetch a transaction
**Every operation requires a transaction id that is obtained by using the javscript [sdk](https://github.com/paylike/sdk).**


```php
	$transaction = \Paylike\Transaction::fetch( $transaction_id);
	// you will now have the transaction data in the $transaction variable.
```
