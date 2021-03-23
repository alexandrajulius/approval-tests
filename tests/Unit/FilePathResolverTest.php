<?php

declare(strict_types=1);

namespace AHJ\ApprovalTests\Tests\Unit;

use AHJ\ApprovalTests\FilePathResolver;
use PHPUnit\Framework\Assert;
use PHPUnit\Framework\TestCase;

final class FilePathResolverTest extends TestCase
{
    public function testGetApprovalFilePath(): void
    {
        $testFilePath = '/Users/alex/Dev/approval-tests/tests/Example/GildedRoseTest.php';
        $actual = (new FilePathResolver())->getApprovalFilePath($testFilePath);
        Assert::assertEquals('tests/Example/approval', $actual);
    }

    public function testGetTestFileName(): void
    {
        $testFilePath = '/Users/alex/Dev/approval-tests/tests/Example/GildedRoseTest.php';
        $testMethodName = 'testUpdateQuality';
        $actual = (new FilePathResolver())->getApprovalFileName($testFilePath, $testMethodName);
        Assert::assertEquals('GildedRoseTest.testUpdateQuality', $actual);
    }
}
