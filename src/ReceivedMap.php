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
                $received[$inputKey] = '[';
                $received[$inputKey] .= implode(', ', $inputValue);
                $received[$inputKey] .= '] -> ';
            }
            // TODO: make sure this works for objects which do not have a __toString method
            if ('object' === gettype($inputValue)) {
                $received[$inputKey] = '[' . $inputValue . '] -> ';
            }
        }

        foreach ($output as $outputKey => $outputValue) {
            if ('array' === gettype($outputValue)) {
                $received[$outputKey] = $received[$outputKey] . '[';
                $received[$outputKey] .= implode(', ', $outputValue);
                $received[$outputKey] .= ']';
            }

            if ('object' === gettype($outputValue)) {
                $received[$outputKey] = $received[$outputKey] . '[' . $outputValue . ']';
            }
        }

        return implode("\n", $received);
    }
}
