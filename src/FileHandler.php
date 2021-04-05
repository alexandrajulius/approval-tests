<?php

declare(strict_types=1);

namespace AHJ\ApprovalTests;

final class FileHandler
{
    /**
     * @param string $path     Example:
     *                         'tests/Example/approval'
     * @param string $fileName
     *                         Example:
     *                         'GildedRoseTest.testUpdateQuality.received.txt'
     */
    public function placeFile(string $path, string $fileName, string $content = null): void
    {
        $this->makeDir($path);
        file_put_contents($path . '/' . $fileName, $content);
    }

    public function deleteReceived(FilePathResolverResult $filePathResolved): void
    {
        if (file_exists($filePathResolved->getReceivedFile())) {
            unlink($filePathResolved->getReceivedFile());
        }
    }

    private function makeDir(string $path): bool
    {
        return is_dir($path) || mkdir($path, 0777, true);
    }
}
