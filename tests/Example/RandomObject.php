<?php

declare(strict_types=1);

namespace AHJ\ApprovalTests\Tests\Example;

final class RandomObject
{
    public string $dirPath;

    public int $fileNumber;

    public function __construct(
        string $dirPath,
        int $fileNumber
    ) {
        $this->dirPath = $dirPath;
        $this->fileNumber = $fileNumber;
    }

    public function getDirPath(): string
    {
        return $this->dirPath;
    }

    public function getFileNumber(): int
    {
        return $this->fileNumber;
    }

}
