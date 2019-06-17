# PHP BingTranslator Wraper 
Simple PHP library Wrappers for Bing translator.

## Installation

Install this package via [Composer](https://getcomposer.org/).

```
composer require renziito/php-bing-translator-wrapper
```

Or edit your project's `composer.json` to require `renziito/php-bing-translator-wrapper` and then run `composer update`.

```json
"require": {
    "renziito/php-bing-translator-wrapper": "^1.0.0"
}
```

## Usage

```php
require_once ('vendor/autoload.php');
use \Renziito\BingTranslate;

$source = 'es';
$target = 'en';
$text = 'buenos días';

$trans = new BingTranslate();
$result = $trans->translate($text, $target, $source);

echo $result;
```