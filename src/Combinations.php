<?php

declare(strict_types=1);

namespace AHJ\ApprovalTests;

final class Combinations
{
    public function getAllCombinations(array $arguments, array $currentCombination = []): array
    {
        $combinations = [];
        $argumentsTail = $arguments;
        $key = key($argumentsTail);
        unset($argumentsTail[$key]);

        if (0 === count($arguments)) {
            return [$currentCombination];
        }

        foreach (current($arguments) as $element) {
            $newCombination = $currentCombination;
            array_push($newCombination, $element);
            $combinations = $this->extend(
                $this->getAllCombinations($argumentsTail, $newCombination),
                $combinations
            );
        }

        return $combinations;
    }

    private function extend(array $first, array $second): array
    {
        foreach ($second as $value) {
            $first[] = $value;
        }

        return $first;
    }
}
