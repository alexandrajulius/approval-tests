<p align="center">
  <a href="https://github.com/alexandrajulius/approval-tests/actions">
    <img src="https://github.com/alexandrajulius/approval-tests/actions/workflows/ci.yml/badge.svg" alt="GitHub Build Status">
  </a>
  <a href="https://scrutinizer-ci.com/g/alexandrajulius/approval-tests/?branch=main">
    <img src="https://scrutinizer-ci.com/g/alexandrajulius/approval-tests/badges/coverage.png?b=main" alt="Scrutinizer Code Quality">
  </a>
  <a href="https://scrutinizer-ci.com/g/alexandrajulius/approval-tests/?branch=main">
    <img src="https://scrutinizer-ci.com/g/alexandrajulius/approval-tests/badges/quality-score.png?b=main" alt="Scrutinizer Code Coverage">
  </a>
</p>

# Approval Tests

## Why to use Approval Tests
Given you have some logic that receives input and creates output,\
and you want to cover it with unit tests,\
and you are too lazy to specify the output for each input in your tests,\
then you should use Approval Tests.

## Usage
Create a test as in the [example](https://github.com/alexandrajulius/approval-tests/blob/main/tests/Example/GildedRoseTest.php) given in this repository.\
Specify the input for your logic, get the output and pass it into\
`Approvals::create()->verifyList($input, $output)`.\
This method will handle two arrays of whatever you put in there 
and internally perform an `Assert::assertEquals($approved, $received)`:
```php
public function testUpdateQuality(): void
{
    $input = [
        new Item('foo', 0, 1),
    ];

    $output = (new GildedRose())->updateQuality($input);

    Approvals::create()->verifyList($input, $output);
}
```
Then run phpunit:
```
$ vendor/bin/phpunit tests
```
Then you will see a new directory in your test directory with two files in it:
```
/approval
  |__ approved.txt
  |__ received.txt
```
The `approved.txt` is initially empty.\
In the `received.txt` you will find the `$input` mapped to the `$output` such as:
```
[foo, 0, 1] -> [foo, -1, 0]
```
Approve the `$output` by copying the content of `received.txt` to `approved.txt` or use the command from your console:
```
$ mv tests/Example/approval/received.txt tests/Example/approval/approved.txt
```

<img width="1157" alt="Screenshot 2021-03-27 at 09 46 18" src="https://user-images.githubusercontent.com/23189414/112715691-1f12a200-8ee2-11eb-9ef5-89d8d4eed9d3.png">

When you run your test again, the `received.txt` will be gone, and you will have your test output in the `approval.txt`.
Next you will just add more cases to your `$input` array in your test and approve the results. 
No need to specify any output manually :)

## How to run
Dependencies:

* [PHP 7.4+](http://php.net/downloads.php)
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
