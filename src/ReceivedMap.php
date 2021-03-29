<?php

declare(strict_types=1);

namespace AHJ\ApprovalTests;

final class ReceivedMap
{
    public function create(array $input, array $output): string
    {
        $received = [];

        foreach ($input as $inputKey => $inputValue) {
            if ('array' === gettype($inputValue)) {
                $received[$inputKey] = '[' . implode(', ', $inputValue) . '] -> ';
            }

            if ('object' === gettype($inputValue)) {
                $received[$inputKey] = '[' . implode(', ', get_object_vars($inputValue)) . '] -> ';
            }
        }

        foreach ($output as $outputKey => $outputValue) {
            if ('array' === gettype($outputValue)) {
                $received[$outputKey] = $received[$outputKey] . '[' . implode(', ', $outputValue) . ']';
            }

            if ('object' === gettype($outputValue)) {
                $received[$outputKey] = $received[$outputKey] . '[' . implode(', ', get_object_vars($outputValue)) . ']';
            }
        }

        return implode("\n", $received);
    }
}
