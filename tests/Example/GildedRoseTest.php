<?php

declare(strict_types=1);

namespace AHJ\ApprovalTests\Tests\Example;

use AHJ\ApprovalTests\Approvals;
use PHPUnit\Framework\TestCase;

final class GildedRoseTest extends TestCase
{
    public function testUpdateQuality(): void
    {
        $input = [
            new Item('foo', 0, 1),
            new Item('bar', 1, 1),
            new Item('zero', 1, 0),
            new Item('zorg', 1, 100),
        ];

        $actual = (new GildedRose())->updateQuality($input);

        Approvals::create()->verifyList($input, $actual);
    }
}
