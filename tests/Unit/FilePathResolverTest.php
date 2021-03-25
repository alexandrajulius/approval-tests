<?php

declare(strict_types=1);

namespace AHJ\ApprovalTests\Tests\Unit;

use AHJ\ApprovalTests\FilePathResolver;
use Generator;
use PHPUnit\Framework\Assert;
use PHPUnit\Framework\TestCase;

final class FilePathResolverTest extends TestCase
{
    /**
     * @dataProvider provideTestFilePath
     */
    public function testGetApprovalFilePath(string $testFilePath, string $expected): void
    {
        $actual = (new FilePathResolver())->getApprovalFilePath($testFilePath);
        Assert::assertEquals($expected, $actual);
    }

    public function provideTestFilePath(): Generator
    {
        yield 'simple test file path' => [
            'testFilePath' => '/Users/alex/Dev/approval-tests/tests/Example/GildedRoseTest.php',
            'expected' => 'tests/Example/approval'
        ];

        yield 'nested test file path' => [
            'testFilePath' => '/Users/alex/Dev/approval-tests/tests/Example/ExtraCase/GildedRoseTest.php',
            'expected' => 'tests/Example/ExtraCase/approval'
        ];
    }

    /**
     * @dataProvider provideTestFileName
     */
    public function testGetTestFileName(string $testFileName, string $testMethodName, string $expected): void
    {
        $actual = (new FilePathResolver())->getApprovalFileName($testFileName, $testMethodName);
        Assert::assertEquals($expected, $actual);
    }

    public function provideTestFileName(): Generator
    {
        yield 'name in simple test file path' => [
            'testFileName' => '/Users/alex/Dev/approval-tests/tests/Example/GildedRoseTest.php',
            'testMethodName' => 'testUpdateQuality',
            'expected' => 'GildedRoseTest.testUpdateQuality'
        ];

        yield 'name in nested test file path' => [
            'testFileName' => '/Users/alex/Dev/approval-tests/tests/ExtraCase/Example/ExtraCase/GildedRoseTest.php',
            'testMethodName' => 'testFunkyMethodInExtraCase',
            'expected' => 'GildedRoseTest.testFunkyMethodInExtraCase'
        ];
    }
}
