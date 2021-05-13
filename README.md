# sinegy-php
PHP library for connecting to the [Sinegy API](https://docs.sinegy.com).

## How to install
````
composer require "ipad90/sinegy-php"
````

## Generating API credentials
Go to [https://marketplace.sinegy.com/user/profile](https://marketplace.sinegy.com/user/profile) to generate API credentials.

## Official Sinegy API Documentation
Link to Sinegy's API documentation page is [https://docs.sinegy.com](https://docs.sinegy.com)

## Example
````
<?php

require('vendor/autoload.php');

use Ipad90\Sinegy\Marketplace;

$sinegy = new Marketplace('API_KEY', 'SECRET_KEY');
$sinegy_btc_ticker = $sinegy->ticker('btcmyr');
print_r($sinegy_btc_ticker);
````
