<?php

declare(strict_types=1);

namespace AHJ\ApprovalTests\Tests\Unit;

use AHJ\ApprovalTests\Combinations;
use Generator;
use PHPUnit\Framework\Assert;
use PHPUnit\Framework\TestCase;

final class CombinationsTest extends TestCase
{
    /**
     * @dataProvider provideTestInput
     */
    public function testGetAllCombinations(array $arguments, array $expected): void
    {
        $actual = (new Combinations())->getAllCombinations($arguments, []);

        Assert::assertEquals($expected, $actual);
    }

    public function provideTestInput(): Generator
    {
        yield 'for name foo and bar' => [
            'arguments' => [
                'name' => ['foo', 'bar'],
                'sellIn' => [3],
                'quantity' => [15],
            ],
            'expected' => [
                ['bar', 3, 15],
                ['foo', 3, 15],
            ],
        ];

        yield 'for sellIn 1 and 3' => [
            'arguments' => [
                ['foo', 'bar'],
                [1, 3],
                [15],
            ],
            'expected' => [
                ['bar', 3, 15],
                ['bar', 1, 15],
                ['foo', 3, 15],
                ['foo', 1, 15],
            ],
        ];

        yield 'for two lists' => [
            'arguments' => [
                ['foo', 'bar'],
                [1, 3],
            ],
            'expected' => [
                ['bar', 3],
                ['bar', 1],
                ['foo', 3],
                ['foo', 1],
            ],
        ];

        yield 'for four flat lists' => [
            'arguments' => [
                ['foo', 'bar'],
                [1, 3],
                [0, 1],
                [4, 5],
            ],
            'expected' => [
                ['bar', 3, 1, 5],
                ['bar', 3, 1, 4],
                ['bar', 3, 0, 5],
                ['bar', 3, 0, 4],
                ['bar', 1, 1, 5],
                ['bar', 1, 1, 4],
                ['bar', 1, 0, 5],
                ['bar', 1, 0, 4],
                ['foo', 3, 1, 5],
                ['foo', 3, 1, 4],
                ['foo', 3, 0, 5],
                ['foo', 3, 0, 4],
                ['foo', 1, 1, 5],
                ['foo', 1, 1, 4],
                ['foo', 1, 0, 5],
                ['foo', 1, 0, 4],
            ],
        ];

        yield 'lots of values' => [
            'arguments' => [
                ['foo', 'bar', 'awesome'],
                [1, 3, 5],
                [15, 50, 100, 101],
            ],
            'expected' => [
                ['awesome', 5, 101],
                ['awesome', 5, 100],
                ['awesome', 5, 50],
                ['awesome', 5, 15],
                ['awesome', 3, 101],
                ['awesome', 3, 100],
                ['awesome', 3, 50],
                ['awesome', 3, 15],
                ['awesome', 1, 101],
                ['awesome', 1, 100],
                ['awesome', 1, 50],
                ['awesome', 1, 15],
                ['bar', 5, 101],
                ['bar', 5, 100],
                ['bar', 5, 50],
                ['bar', 5, 15],
                ['bar', 3, 101],
                ['bar', 3, 100],
                ['bar', 3, 50],
                ['bar', 3, 15],
                ['bar', 1, 101],
                ['bar', 1, 100],
                ['bar', 1, 50],
                ['bar', 1, 15],
                ['foo', 5, 101],
                ['foo', 5, 100],
                ['foo', 5, 50],
                ['foo', 5, 15],
                ['foo', 3, 101],
                ['foo', 3, 100],
                ['foo', 3, 50],
                ['foo', 3, 15],
                ['foo', 1, 101],
                ['foo', 1, 100],
                ['foo', 1, 50],
                ['foo', 1, 15],
            ],
        ];
    }
}
