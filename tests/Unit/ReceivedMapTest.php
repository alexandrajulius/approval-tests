<?php

declare(strict_types=1);

namespace AHJ\ApprovalTests\Tests\Unit;

use AHJ\ApprovalTests\ReceivedMap;
use AHJ\ApprovalTests\Tests\Example\Item;
use AHJ\ApprovalTests\Tests\Example\RandomObject;
use AHJ\ApprovalTests\Tests\Example\YetAnotherRandomObject;
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
        yield 'array foo' => [
            'input' => [
                ['foo', 0, 1],
            ],
            'output' => [
                ['foo', -1, 0],
            ],
            'expected' => '[foo, 0, 1] -> [foo, -1, 0]',
        ];

        yield 'object without __toString method' => [
            'input' => [
                new RandomObject('foo', 0, []),
                new RandomObject('foo', 10, []),
            ],
            'output' => [
                new RandomObject('bar', 10, []),
                new RandomObject('bar', 100, []),
            ],
            'expected' => '[foo, 0, []] -> [bar, 10, []]
[foo, 10, []] -> [bar, 100, []]',
        ];

        yield 'nested objects' => [
            'input' => [
                new YetAnotherRandomObject('foo', 0, new RandomObject('bar', 10, [])),
                new YetAnotherRandomObject('foo', 10, new RandomObject('bar', 100, [])),
            ],
            'output' => [
                new YetAnotherRandomObject('foo', 10, new RandomObject('bar', 60, [])),
                new YetAnotherRandomObject('foo', 100, new RandomObject('bar', 600, [])),
            ],
            'expected' => '[foo, 0, [bar, 10, []]] -> [foo, 10, [bar, 60, []]]
[foo, 10, [bar, 100, []]] -> [foo, 100, [bar, 600, []]]',
        ];

        yield 'nested objects including arrays' => [
            'input' => [
                new YetAnotherRandomObject('foo', 0, new RandomObject('bar', 10, [1, 2, 'foo'])),
                new YetAnotherRandomObject('foo', 10, new RandomObject('bar', 100, [1, 2, 'foo'])),
            ],
            'output' => [
                new YetAnotherRandomObject('foo', 10, new RandomObject('bar', 60, [1, 2, 'foo'])),
                new YetAnotherRandomObject('foo', 100, new RandomObject('bar', 600, [1, 2, 'foo'])),
            ],
            'expected' => '[foo, 0, [bar, 10, [1, 2, foo]]] -> [foo, 10, [bar, 60, [1, 2, foo]]]
[foo, 10, [bar, 100, [1, 2, foo]]] -> [foo, 100, [bar, 600, [1, 2, foo]]]',
        ];

        yield 'nested objects including arrays of arrays' => [
            'input' => [
                new YetAnotherRandomObject('foo', 0, new RandomObject('bar', 10, [1, 2, 'foo', [1, 3]])),
                new YetAnotherRandomObject('foo', 10, new RandomObject('bar', 100, [1, 2, 'foo', [1, 3]])),
            ],
            'output' => [
                new YetAnotherRandomObject('foo', 10, new RandomObject('bar', 60, [1, 2, 'foo', [1, 3]])),
                new YetAnotherRandomObject('foo', 100, new RandomObject('bar', 600, [1, 2, 'foo', [1, 3]])),
            ],
            'expected' => '[foo, 0, [bar, 10, [1, 2, foo, [1, 3]]]] -> [foo, 10, [bar, 60, [1, 2, foo, [1, 3]]]]
[foo, 10, [bar, 100, [1, 2, foo, [1, 3]]]] -> [foo, 100, [bar, 600, [1, 2, foo, [1, 3]]]]',
        ];

        yield 'nested objects including arrays with objects' => [
            'input' => [
                new YetAnotherRandomObject('foo', 0, new RandomObject('bar', 10, [new YetAnotherRandomObject('bar', 1, new RandomObject('bar', 10, [1]))])),
                new YetAnotherRandomObject('foo', 10, new RandomObject('bar', 100, [new YetAnotherRandomObject('bar', 1, new RandomObject('bar', 10, [1]))])),
            ],
            'output' => [
                new YetAnotherRandomObject('foo', 10, new RandomObject('bar', 60, [new YetAnotherRandomObject('bar', 1, new RandomObject('bar', 10, [1]))])),
                new YetAnotherRandomObject('foo', 100, new RandomObject('bar', 600, [new YetAnotherRandomObject('bar', 1, new RandomObject('bar', 10, [1]))])),
            ],
            'expected' => '[foo, 0, [bar, 10, [[bar, 1, [bar, 10, [1]]]]]] -> [foo, 10, [bar, 60, [[bar, 1, [bar, 10, [1]]]]]]
[foo, 10, [bar, 100, [[bar, 1, [bar, 10, [1]]]]]] -> [foo, 100, [bar, 600, [[bar, 1, [bar, 10, [1]]]]]]',
        ];

        yield 'nested arrays' => [
            'input' => [
                ['foo', 0, 1, [100, 1000]],
            ],
            'output' => [
                ['foo', -1, 0, [600, 6000]],
            ],
            'expected' => '[foo, 0, 1, [100, 1000]] -> [foo, -1, 0, [600, 6000]]',
        ];

        yield 'object with __toString method' => [
            'input' => [
                new Item('foo', 0, 1),
            ],
            'output' => [
                new Item('foo', -1, 0),
            ],
            'expected' => '[foo, 0, 1] -> [foo, -1, 0]',
        ];

        yield 'more objects with __toString method' => [
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
