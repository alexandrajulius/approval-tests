<?php

declare(strict_types=1);

namespace AHJ\ApprovalTests;

final class ReceivedMap
{
    /**
     * @param array|string $output
     */
    public function create(array $input, $output, bool $plain = false): string
    {
        $receivedMap = [];

        if (!empty($input)) {
            foreach ($input as $inputKey => $inputValue) {
                $receivedMap[$inputKey] = '[' . $this->serializeMixedType($inputValue) . '] -> ';
            }
        }

        if (!$plain) {
            foreach ($output as $outputKey => $outputValue) {
                if (!empty($input)) {
                    $receivedMap[$outputKey] = $receivedMap[$outputKey] . '[' . $this->serializeMixedType($outputValue) . ']';
                } else {
                    $receivedMap[$outputKey] = '[' . $this->serializeMixedType($outputValue) . ']';
                }
            }
        } else {
            return 'string' === gettype($output) ? $output : json_encode($output);
        }

        return $this->cleanAndFlatten($receivedMap);
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
     * @param array $received Example:
     *                        [
     *                        [0] => '[foo, 0, [bar, 10, ]] -> [foo, 10, [bar, 60, ]]',
     *                        [1] => '[foo, 10, [bar, 100, ]] -> [foo, 100, [bar, 600, ]]'
     *                        ]
     *
     * @return string Example:
     *                '[foo, 0, [bar, 10]] -> [foo, 10, [bar, 60]]\n
     *                [foo, 10, [bar, 100]] -> [foo, 100, [bar, 600]]'
     */
    private function cleanAndFlatten(array $received): string
    {
        return str_replace(', ]', ']', implode("\n", $received));
    }
}
