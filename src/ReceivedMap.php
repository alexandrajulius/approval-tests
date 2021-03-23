<?php

declare(strict_types=1);

namespace AHJ\ApprovalTests;

final class ReceivedMap
{
    /**
     * @param array $input Example
     *       [0] =>
     *           class AHJ\ApprovalTests\Tests\Example\Item#13 (3) {
     *           public $name => 'foo'
     *           public $sell_in => 0
     *           public $quality => 1
     *       }
     * @param array $output Example
     *      [0] =>
     *           class AHJ\ApprovalTests\Tests\Example\Item#18 (3) {
     *           public $name => 'foo'
     *           public $sell_in => -1
     *           public $quality => 0
     *       }
     * @return string Example
     *          [foo, 0, 1] -> [foo, -1, 0]
     */
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
