<?php

declare(strict_types=1);

namespace AHJ\ApprovalTests;

final class ReceivedMap
{
    public function create(array $input, array $output): string
    {
        $received = [];

        foreach ($input as $inputKey => $inputValue) {
            $received[$inputKey] = '[' . $this->serializeMixedType($inputValue) . '] -> ';
        }

        foreach ($output as $outputKey => $outputValue) {
            $received[$outputKey] = $received[$outputKey] . '[' . $this->serializeMixedType($outputValue) . ']';
        }

        return $this->cleanAndFlatten($received);
    }

    private function serializeMixedType($inputValue, string $currentConcatenations = ''): string
    {
        $concatenations = '';

        if ('string' === gettype($inputValue)) {
            return $currentConcatenations . $inputValue;
        }

        foreach ($inputValue as $item) {
            if ('array' === gettype($item) || 'object' === gettype($item)) {
                $concatenations .= '[' . $this->serializeMixedType($item, $concatenations) . ']';
            } else {
                $concatenations .= $item . ', ';
            }
        }

        return $concatenations;
    }

    /**
     * @param array $received
     *                        Example:
     *                        [
     *                        [0] => '[foo, 0, [bar, 10, ]] -> [foo, 10, [bar, 60, ]]',
     *                        [1] => '[foo, 10, [bar, 100, ]] -> [foo, 100, [bar, 600, ]]'
     *                        ]
     *
     * @return string
     *                Example:
     *                '[foo, 0, [bar, 10]] -> [foo, 10, [bar, 60]]
     *                [foo, 10, [bar, 100]] -> [foo, 100, [bar, 600]]'
     */
    private function cleanAndFlatten(array $received): string
    {
        return str_replace(', ]', ']', implode("\n", $received));
    }
}
