<?php

declare(strict_types=1);

namespace AHJ\ApprovalTests;

final class CombinationApprovals
{
    private Combinations $combinations;

    private Approvals $approvals;

    public static function create(): self
    {
        return new self(
            new Combinations(),
            Approvals::create()
        );
    }

    public function __construct(
        Combinations $combinations,
        Approvals $approvals
    ) {
        $this->combinations = $combinations;
        $this->approvals = $approvals;
    }

    public function verifyAllCombinations(callable $function, array $arguments): void
    {
        $inputCombinations = $this->combinations->getAllCombinations($arguments, []);

        $output = [];

        foreach ($inputCombinations as $combination) {
            $output = $this->extend($output, call_user_func($function, ...$combination));
        }

        $this->approvals->verifyList($inputCombinations, $output);
    }

    private function extend(array $first, array $second): array
    {
        foreach ($second as $value) {
            $first[] = $value;
        }

        return $first;
    }
}
