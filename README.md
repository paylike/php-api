# Paylike PHP Api Wrapper

This is the PHP wrapper for the Paylike [sdk](https://github.com/paylike/sdk)

[Sign up for a free merchant account (free and instant)](https://paylike.io)

- Table of contents
	- [Getting an API key](#getting-an-api-key)
	- [Requirements](#requirements)
	- [Examples](#examples)
	- [Getting started](#getting-started)
	- [Capturing a transaction](#capturing-a-transaction)
	- [Refund a transaction](#refund-a-transaction)
	- [Void a transaction](#void-a-transaction)
	- [Fetch a transaction](#fetch-a-transaction)
	- [Create a transaction](#create-a-transaction)
	- [Fetch a card](#fetch-a-card)

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
$privateAppKey = 'your-private-key-goes-here';
\Paylike\Client::setKey( $privateAppKey );
```


## Capturing a transaction
**Every operation requires a transaction id that is obtained by using the javascript [sdk](https://github.com/paylike/sdk).**

```php
	 $data     = array(
                    'amount'   => $amount,      //value must be in cents 
                    'currency' => $currency     //see available formats https://github.com/paylike/currencies
                );
     $transaction = \Paylike\Transaction::capture( $transactionId, $data );
	// you will now have the transaction data in the $transaction variable.
```


## Refund a transaction
**Every operation requires a transaction id that is obtained by using the javascript [sdk](https://github.com/paylike/sdk).**


```php
	$data     = array(
                    'amount'     => $amount,    //value must be in cents 
                    'descriptor' => $reason     //is optional see https://github.com/paylike/descriptor for format and restrictions.
                );
    $transaction = \Paylike\Transaction::refund( $transactionId, $data );
	// you will now have the transaction data in the $transaction variable.
```

## Void a transaction
**Every operation requires a transaction id that is obtained by using the javascript [sdk](https://github.com/paylike/sdk).**


```php
	$data     = array( 
	                'amount' => $amount     //value must be in cents 
	                );
    $transaction = \Paylike\Transaction::void( $transactionId, $data );
	// you will now have the transaction data in the $transaction variable.
```

## Fetch a transaction
**Every operation requires a transaction id that is obtained by using the javascript [sdk](https://github.com/paylike/sdk).**


```php
	$transaction = \Paylike\Transaction::fetch( $transactionId);
	// you will now have the transaction data in the $transaction variable.
```

## Create a transaction
**Every operation requires a transaction id that is obtained by using the javascript [sdk](https://github.com/paylike/sdk).**


```php
	 $data     = array(
                    'amount'   => $amount,      //value must be in cents 
                    'currency' => $currency     //see available formats https://github.com/paylike/currencies
                );
     $transaction = \Paylike\Transaction::create( $transactionId, $data );
	// you will now have the transaction data in the $transaction variable.
```

## Fetch a card
**Every operation requires a card id that is obtained by using the javascript [sdk](https://github.com/paylike/sdk).**


```php
	$card = \Paylike\Card::fetch( $cardId );
	// you will now have the card data in the $card variable.
```