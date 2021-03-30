<?php

declare(strict_types=1);

namespace AHJ\ApprovalTests\Tests\Example;

final class YetAnotherRandomObject
{
    public string $dirPath;

    public int $fileNumber;

    public RandomObject $randomObject;

    public function __construct(
        string $dirPath,
        int $fileNumber,
        RandomObject $randomObject
    ) {
        $this->dirPath = $dirPath;
        $this->fileNumber = $fileNumber;
        $this->randomObject = $randomObject;
    }

    public function getDirPath(): string
    {
        return $this->dirPath;
    }

    public function getFileNumber(): int
    {
        return $this->fileNumber;
    }

    public function getYetAnotherRandomObject(): RandomObject
    {
        return $this->randomObject;
    }
}
