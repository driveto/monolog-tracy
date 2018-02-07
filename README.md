# [Tracy](https://tracy.nette.org) BlueScreen handler for [Monolog](https://github.com/Seldaek/monolog)

[![Build Status](https://travis-ci.org/driveto/monolog-tracy.svg?branch=master)](https://travis-ci.org/driveto/monolog-tracy)

This is a fork of [monolog-tracy](https://github.com/nella/monolog-tracy) which allows you to define exceptions excluded from being saved into the file.

## Installation

Using  [Composer](http://getcomposer.org/):

```sh
$ composer require nella/monolog-tracy
```

## Blue Screen Handler

Converts your exception reports into beautiful and clear html files using [Tracy](https://tracy.nette.org).

[![Uncaught exception rendered by Tracy](http://nette.github.io/tracy/images/tracy-exception.png)](http://nette.github.io/tracy/tracy-exception.html)

### Tell me how!

Just push the handler into the stack.

```php
use Nella\MonologTracy\BlueScreenHandler;
use Nella\MonologTracy\Tracy\BlueScreenFactory;
use Nella\MonologTracy\Tracy\LoggerHelper;

$logger = new Monolog\Logger('channel');

$factory = new BlueScreenFactory();
$helper = new LoggerHelper(__DIR__ . '/log', $factory->create());
$handler = new BlueScreenHandler($helper);

$logger->pushHandler($handler);
```

… Profit!

```php
$logger->critical('Exception occured!', array(
    'exception' => new Exception(),
));
```
