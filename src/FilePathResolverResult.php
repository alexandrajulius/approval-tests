<?php

declare(strict_types=1);

namespace AHJ\ApprovalTests;

final class FilePathResolverResult
{
    public string $dirPath;

    public string $fileName;

    public function __construct(
        string $dirPath,
        string $fileName
    ) {
        $this->dirPath = $dirPath;
        $this->fileName = $fileName;
    }

    public function getDirPath(): string
    {
        return $this->dirPath;
    }

    public function getFileName(): string
    {
        return $this->fileName;
    }

    public function getReceivedName(): string
    {
        return sprintf('%s.received.txt', $this->fileName);
    }

    public function getApprovedName(): string
    {
        return sprintf('%s.approved.txt', $this->fileName);
    }

    public function getReceivedFile(): string
    {
        return sprintf('%s/%s.received.txt', $this->dirPath, $this->fileName);
    }

    public function getApprovedFile(): string
    {
        return sprintf('%s/%s.approved.txt', $this->dirPath, $this->fileName);
    }
}
