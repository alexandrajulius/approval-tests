<?php

declare(strict_types=1);

namespace AHJ\ApprovalTests;

final class ReceivedMap
{
    public function create(array $input, array $output): string
    {
        $received = [];

        foreach ($input as $inputKey => $inputValue) {
            $received[$inputKey] = '[' . $inputValue . '] -> ';
        }

        foreach ($output as $outputKey => $outputValue) {
            $received[$outputKey] = $received[$outputKey] . '[' . $outputValue . ']';
        }

        return implode("\n", $received);
    }
}
