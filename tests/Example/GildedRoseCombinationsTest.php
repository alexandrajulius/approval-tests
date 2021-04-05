<?php

declare(strict_types=1);

namespace AHJ\ApprovalTests\Tests\Example;

use AHJ\ApprovalTests\CombinationApprovals;
use PHPUnit\Framework\TestCase;

final class GildedRoseCombinationsTest extends TestCase
{
    public function testUpdateQualityWithCombinations(): void
    {
        //TODO: provide possibility to use range
        $arguments = [
            ['foo', 'Aged Brie', 'zorg'],
            [3, 9, 10],
            [15, 8, 11],
        ];

        CombinationApprovals::create()->verifyAllCombinations(
            function (string $name, int $sellIn, int $quantity) {
                $items = [new Item($name, $sellIn, $quantity)];

                return (new GildedRose())->updateQuality($items);
            },
            $arguments
        );
    }
}
