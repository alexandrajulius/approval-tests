<?php

declare(strict_types=1);

namespace AHJ\ApprovalTests\Tests\Example;

use AHJ\ApprovalTests\CombinationApprovals;
use PHPUnit\Framework\TestCase;

final class GildedRoseCombinationsTest extends TestCase
{
    public function testUpdateQualityWithCombinations(): void
    {
        $arguments = [
            ['foo', 'bar'],
            range(0, 3),
            [15, 20, 25],
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
