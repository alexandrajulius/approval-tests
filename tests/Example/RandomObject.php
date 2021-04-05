<?php

declare(strict_types=1);

namespace AHJ\ApprovalTests\Tests\Example;

final class RandomObject
{
    public string $dirPath;

    public int $fileNumber;

    public array $randomList;

    public function __construct(
        string $dirPath,
        int $fileNumber,
        array $randomList
    ) {
        $this->dirPath = $dirPath;
        $this->fileNumber = $fileNumber;
        $this->randomList = $randomList;
    }

    public function getDirPath(): string
    {
        return $this->dirPath;
    }

    public function getFileNumber(): int
    {
        return $this->fileNumber;
    }

    public function getRandomList(): array
    {
        return $this->randomList;
    }
}
