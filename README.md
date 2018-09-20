# Paylike client (PHP)

You can sign up for a Paylike account at [https://paylike.io](https://paylike.io).

## Getting an API key

An API key can be obtained by creating a merchant and adding an app through
Paylike [dashboard](https://app.paylike.io). 

## Requirements

PHP 5.3.3 and later.

## Install

You can install the package via [Composer](http://getcomposer.org/). Run the following command:

```bash
composer require paylike/php-api
```

If you don't use Composer, you can download the [latest release](https://github.com/paylike/php-api/releases) and include the `init.php` file.

```php
require_once('/path/to/php-api/init.php');
```

## Dependencies

The bindings require the following extension in order to work properly:

- [`curl`](https://secure.php.net/manual/en/book.curl.php)

If you use Composer, these dependencies should be handled automatically. If you install manually, you'll want to make sure that these extensions are available.  
If you don't want to use curl, you can create your own client to extend from `HttpClientInterface` and send that as a parameter when instantiating the `Paylike` class.

## Example

```php
$paylike = new \Paylike\Paylike($private_api_key);
 
// fetch a card
$cards = $paylike->cards();
$card  = $cards->fetch($card_id);
 
// capture a transaction
$transactions = $paylike->transactions();
$transaction  = $transactions->capture($transaction_id, array(
    'amount'   => 100,
    'currency' => 'EUR'
));
``` 

## Methods
```php
$paylike = new \Paylike\Paylike($private_api_key);
 
$apps = $paylike->apps();
$apps->create($args);
$apps->fetch();
 
$merchants = $paylike->merchants();
$merchants->create($args);
$merchants->fetch($merchant_id);
$merchants->update($merchant_id, $args);
$all_merchants = $merchants->find($app_id,$args);
$some_merchants = $merchants->before($app_id,$before);
$some_merchants = $merchants->after($app_id,$before);
 
$cards = $paylike->cards();
$cards->create($merchant_id, $args);
$cards->fetch($card_id);
 
$transactions = $paylike->transactions();
$transactions->create($merchant_id, $args);
$transactions->fetch($transaction_id);
$transactions->capture($transaction_id, $args);
$transactions->void($transaction_id, $args);
$transactions->refund($transaction_id, $args);
$all_transactions = $transactions->find($merchant_id,$args);
$some_transactions = $transactions->before($merchant_id,$before);
$some_transactions = $transactions->after($merchant_id,$before);

// explicit args
$limit = 10;
$after = '5b8e839d7cc76f04ecd3f733';
$before = '5b98deef882cf804f6108700';
$api_transactions = $transactions->find($merchant_id, array(
    'limit' => $limit,
    'after' => $after,
    'before' => $before,
    'filter' => array(
    	'successful' => true
    )
));
``` 

## Pagination
The methods that return multiple merchants/transactions (find,after,before) use cursors, so you don't need to worry about pagination, you can access any index, or iterate all the items, this is handled in the background.

## Error handling

The api wrapper will throw errors when things do not fly. All errors inherit from
`ApiException`. A very verbose example of catching all types of errors:

```php
$paylike = new \Paylike\Paylike($private_api_key);
try {
    $transactions = $paylike->transactions();
    $transactions->capture($transaction_id, array(
        'amount'   => 100,
        'currency' => 'EUR'
    ));
} catch (\Paylike\Exception\NotFound $e) {
    // The transaction was not found
} catch (\Paylike\Exception\InvalidRequest $e) {
    // Bad (invalid) request - see $e->getJsonBody() for the error
} catch (\Paylike\Exception\Forbidden $e) {
    // You are correctly authenticated but do not have access.
} catch (\Paylike\Exception\Unauthorized $e) {
    // You need to provide credentials (an app's API key)
} catch (\Paylike\Exception\Conflict $e) {
    // Everything you submitted was fine at the time of validation, but something changed in the meantime and came into conflict with this (e.g. double-capture).
} catch (\Paylike\Exception\ApiConnection $e) {
    // Network error on connecting via cURL
} catch (\Paylike\Exception\ApiException $e) {
    // Unknown api error
}
``` 

In most cases catching `NotFound` and `InvalidRequest` as client errors
and logging `ApiException` would suffice.

## Development

Install dependencies:

``` bash
composer install
```

## Tests

Install dependencies as mentioned above (which will resolve [PHPUnit](http://packagist.org/packages/phpunit/phpunit)), then you can run the test suite:

```bash
./vendor/bin/phpunit
```
 