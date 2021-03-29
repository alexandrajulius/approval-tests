<?php

declare(strict_types=1);

namespace AHJ\ApprovalTests\Tests\Unit;

use AHJ\ApprovalTests\ReceivedMap;
use AHJ\ApprovalTests\Tests\Example\Item;
use AHJ\ApprovalTests\Tests\Example\RandomObject;
use Generator;
use PHPUnit\Framework\Assert;
use PHPUnit\Framework\TestCase;

final class ReceivedMapTest extends TestCase
{
    /**
     * @dataProvider provideTestInput
     */
    public function testCreate(array $input, array $output, string $expected): void
    {
        $actual = (new ReceivedMap())->create($input, $output);

        Assert::assertEquals($expected, $actual);
    }

    public function provideTestInput(): Generator
    {
        yield 'for array foo' => [
            'input' => [
                ['foo', 0, 1],
            ],
            'output' => [
                ['foo', -1, 0],
            ],
            'expected' => '[foo, 0, 1] -> [foo, -1, 0]',
        ];

        yield 'for object without __toString method' => [
            'input' => [
                new RandomObject('foo', 0),
                new RandomObject('foo', 10),
            ],
            'output' => [
                new RandomObject('bar', 10),
                new RandomObject('bar', 100),
            ],
            'expected' => '[foo, 0] -> [bar, 10]
[foo, 10] -> [bar, 100]',
        ];

        yield 'for object with __toString method' => [
            'input' => [
                new Item('foo', 0, 1),
            ],
            'output' => [
                new Item('foo', -1, 0),
            ],
            'expected' => '[foo, 0, 1] -> [foo, -1, 0]',
        ];

        yield 'for more objects with __toString method' => [
            'input' => [
                new Item('bar', 1, 1),
                new Item('bar', 1, 0),
                new Item('bar', 1, 100),
            ],
            'output' => [
                new Item('bar', -1, 0),
                new Item('bar', 1, 10),
                new Item('bar', -1, 50),
            ],
            'expected' => '[bar, 1, 1] -> [bar, -1, 0]
[bar, 1, 0] -> [bar, 1, 10]
[bar, 1, 100] -> [bar, -1, 50]',
        ];
    }
}
