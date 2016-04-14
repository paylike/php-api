Paylike PHP API Wrapper
=======================

This is a PHP wrapper around the [Paylike](https://paylike.io) API.


Warning
-------

This package is in very early stage of development, things are likely to break
in the future until a stable version is released. Use at your own risks.


Installation
------------

Install this package via Composer:

``` bash
$ composer require paylike/php-api
```

You then have to install an HTTP Client. We use HTTPlug as an HTTP Client agnostic adapter.
If you don't have one already installed or don't really know what to do at this point,
you can check the [HTTPlug documentation](http://docs.php-http.org/en/latest/httplug/users.html)
or just trust us with a default client:

``` bash
$ composer require php-http/guzzle6-adapter
```

This will install Guzzle 6 and everything you need to plug it with our package.


Usage
-----

```php
<?php

use Paylike\Paylike;
use Paylike\HttpClientFactory;

$apiKey = 'your-api-key';

$paylike = new Paylike(HttpClientFactory::create($apiKey));
$transaction = $paylike->transaction()->findOne($transactionId);
```


TODO
----

* Implements remainings API methods
* Tests and documentation


Credits
-------

* Paylike ApS - <https://paylike.io>
* Hubert Moutot - <hubert.moutot@gmail.com>


Contributing
------------

Please refer to the [CONTRIBUTING.MD](CONTRIBUTING.md) file.


License
-------

This package is released under the MIT License. See the bundled [LICENSE](LICENSE) file for details.
