# Approval Tests

## Why to use Approval Tests
Given you have some logic that receives input and creates output,\
and you want to cover it with unit tests,\
and you are too lazy to specify the output for each input in your tests,\
then you should use Approval Tests.

## Usage
### Approval command
mv tests/Example/approval/GildedRoseTest.testUpdateQuality.received.txt tests/Example/approval/GildedRoseTest.testUpdateQuality.approved.txt

## How to run
Dependencies:

* [PHP 7.1+](http://php.net/downloads.php)
* [composer](https://getcomposer.org/)

Clone the repository and run:
```
$ composer install
```

## How to test
Dependencies:

* [phpunit 9+](https://phpunit.de/getting-started/phpunit-9.html)

Run test suites in root directory
```
$ vendor/bin/phpunit tests --testdox --colors
```

## Author Contact
[alexandra.julius@gmail.com](mailto:alexandra.julius@gmail.com)
