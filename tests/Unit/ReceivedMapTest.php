<?php

declare(strict_types=1);

namespace AHJ\ApprovalTests\Tests\Unit;

use AHJ\ApprovalTests\ReceivedMap;
use AHJ\ApprovalTests\Tests\Example\Item;
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
        yield 'for item foo' => [
            'input' => [
                new Item('foo', 0, 1),
            ],
            'output' => [
                new Item('foo', -1, 0),
            ],
            'expected' => '[foo, 0, 1] -> [foo, -1, 0]',
        ];

        yield 'for item bar' => [
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
