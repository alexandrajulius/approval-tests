<?php

declare(strict_types=1);

namespace AHJ\ApprovalTests\Tests\Example;

final class GildedRose
{
    public function updateQuality(array $items): array
    {
        $result = [];

        foreach ($items as $item) {
            $result[] = $this->updateItemQuality($item);
        }

        return $result;
    }

    public function updateItemQuality(Item $item): Item
    {
        $item = clone $item;

        switch ($item->name) {
            case 'Aged Brie':
                if ($item->quality < 50) {
                    $item->quality = $item->quality + 1;
                }
                $item->sell_in = $item->sell_in - 1;

                if ($item->sell_in < 0 && $item->quality < 50) {
                    $item->quality = $item->quality + 1;
                }

                return $item;
            case 'Backstage passes to a TAFKAL80ETC concert':
                if ($item->quality < 50) {
                    $item->quality = $item->quality + 1;

                    if ($item->sell_in < 11) {
                        if ($item->quality < 50) {
                            $item->quality = $item->quality + 1;
                        }
                    }

                    if ($item->sell_in < 6) {
                        if ($item->quality < 50) {
                            $item->quality = $item->quality + 1;
                        }
                    }
                }
                $item->sell_in = $item->sell_in - 1;

                if ($item->sell_in < 0) {
                    $item->quality = 0;
                }

                return $item;
            case 'Sulfuras, Hand of Ragnaros':
                break;
            default:
                if ($item->quality > 0) {
                    $item->quality = $item->quality - 1;
                }
                $item->sell_in = $item->sell_in - 1;

                if ($item->sell_in < 0) {
                    if ($item->quality > 0) {
                        $item->quality = $item->quality - 1;
                    }
                }

                return $item;
        }

        return $item;
    }
}
