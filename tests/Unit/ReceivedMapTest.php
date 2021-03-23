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
         yield 'for item Conjured' => [
             'input' => [
                 new Item('foo', 0, 1)
             ],
             'output' => [
                 new Item('foo', -1, 0)
             ],
             'expected' => '[foo, 0, 1] -> [foo, -1, 0]'
         ];
     }
}
