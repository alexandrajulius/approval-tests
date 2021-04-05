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
  <a href="https://packagist.org/packages/ahj/approval-tests">
    <img src="https://img.shields.io/badge/License-MIT-blue.svg" alt="Approval Tests on packagist.org">
  </a>
</p>

# Approval Tests

## Why to use Approval Tests
Given you have (possibly legacy) code that receives input and creates output,\
and you want to cover it with regression tests,\
and you don't want to specify the output for each input in your unit tests,\
and you don't want to adjust all the tested output after you changed the logic,\
then you should use Approval Tests.

## Installation
```
composer require ahj/approval-tests --dev
```

## Usage
Find an example on how to do Approval Testing under [/tests/Example](https://github.com/alexandrajulius/approval-tests/tree/main/tests/Example). 

Create a test with phpunit, specify the input for your logic, store the output in a 
variable and pass it into\
`Approvals::create()->verifyList($input, $output)`:
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
`verifyList($input, $output)` will create a map of the received data and compare it to 
the previous version of this data by performing an `Assert::assertEquals($approved, $received)`.

Then run phpunit:
```
$ vendor/bin/phpunit tests
```
Then you will see a new directory in your test directory that contains two files:
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

### Options

Pass an empty array as `$input` if your logic doesn't require input:
```php
    Approvals::create()->verifyList([], $output);
```

In the `received.txt` you will only show the `$output` such as:
```
[foo, -1, 0]
```

Pass `$plain = true` as third argument to `verifyList()` in order to have 
non formated output in the `received.txt`:
```php
    Approvals::create()->verifyList([], $output, true);
```




## Testing Combinations
### When to use Combinations
You have a function that takes, for example, three arguments, 
and you want to test its behaviour with a bunch of different values 
for each of those arguments.

Copy the below code or use this repo's [example](https://github.com/alexandrajulius/approval-tests/blob/main/tests/Example/GildedRoseCombinationsTest.php) 
and adjust the number and type of inputs for your use case.
Specify the input arguments of the method you want to test in `$arguments`:
Either list the values that the arguments can take explicitly in arrays 
or use `range()`.
Then pass those arguments along with an anonymous function into
`CombinationApprovals::create()->verifyAllCombinations()`

```php
public function testUpdateQualityWithCombinations(): void
{
    $arguments = [
        ['foo', 'bar'], # values for $name
        range(0, 3),    # values for $sellIn
        [15, 20, 25],   # values for $quantity
    ];

    CombinationApprovals::create()->verifyAllCombinations(
        function (string $name, int $sellIn, int $quantity) {
            $items = [new Item($name, $sellIn, $quantity)];
    
            return (new GildedRose())->updateQuality($items);
        },
        $arguments
    );
}
```

The anonymous function specifies how the input arguments should be passed 
into the logic that you want to test. Also, it must return the output of 
your tested logic, so `verifyAllCombinations()` can dump it into
the received.txt and compare it to the latest approved.txt.

For the above example, the Approval tool would create all possible combinations
of the specified input values, map those to the related output of the tested logic
and dump it into the received.txt as such:
```
[bar, 3, 25] -> [bar, 2, 24]
[bar, 3, 20] -> [bar, 2, 19]
[bar, 3, 15] -> [bar, 2, 14]
[bar, 2, 25] -> [bar, 1, 24]
[bar, 2, 20] -> [bar, 1, 19]
[bar, 2, 15] -> [bar, 1, 14]
[bar, 1, 25] -> [bar, 0, 24]
[bar, 1, 20] -> [bar, 0, 19]
[bar, 1, 15] -> [bar, 0, 14]
[bar, 0, 25] -> [bar, -1, 23]
[bar, 0, 20] -> [bar, -1, 18]
[bar, 0, 15] -> [bar, -1, 13]
[foo, 3, 25] -> [foo, 2, 24]
[foo, 3, 20] -> [foo, 2, 19]
[foo, 3, 15] -> [foo, 2, 14]
[foo, 2, 25] -> [foo, 1, 24]
[foo, 2, 20] -> [foo, 1, 19]
[foo, 2, 15] -> [foo, 1, 14]
[foo, 1, 25] -> [foo, 0, 24]
[foo, 1, 20] -> [foo, 0, 19]
[foo, 1, 15] -> [foo, 0, 14]
[foo, 0, 25] -> [foo, -1, 23]
[foo, 0, 20] -> [foo, -1, 18]
[foo, 0, 15] -> [foo, -1, 13]
```

## How to run
Dependencies:

* [PHP 7.4+](http://php.net/downloads.php)
* [phpunit 9+](https://phpunit.de/getting-started/phpunit-9.html)
* [composer](https://getcomposer.org/)

Clone the repository and run:
```
$ composer install
```

## How to test
Dependencies:

* [phpunit 9+](https://phpunit.de/getting-started/phpunit-9.html)
* [php-code-coverage 9+](https://php.watch/articles/php-code-coverage-comparison)
* [phpstan](https://phpstan.org/user-guide/getting-started)
* [php-cs-fixer](https://cs.symfony.com/)

Run all tests, code coverage and code quality checks in your root directory with
```
$ composer test-all
```

## Author Contact
[alexandra.julius@gmail.com](mailto:alexandra.julius@gmail.com)
