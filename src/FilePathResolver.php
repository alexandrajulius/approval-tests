<?php

declare(strict_types=1);

namespace AHJ\ApprovalTests;

final class FilePathResolver
{
    const APPROVAL_DIR = 'approval';

    public function resolve(): FilePathResolverResult
    {
        $pathToTestFile = debug_backtrace(1)[1]['file'];
        $testMethodName = debug_backtrace(1)[2]['function'];

        $approvalFilePath = $this->getApprovalFilePath($pathToTestFile);
        $approvalFileName = $this->getApprovalFileName($pathToTestFile, $testMethodName);

        return new FilePathResolverResult($approvalFilePath, $approvalFileName);
    }

    public function getApprovalFilePath(string $pathToTestFile): string
    {
        $pathParts = explode('/', pathinfo($pathToTestFile)['dirname']);
        $flip = array_flip($pathParts);
        $startKey = $flip['tests'];
        $endKey = count($pathParts) - 1;

        $approvalFilePath = '';
        for ($i = $startKey; $i <= $endKey; $i++) {
            $approvalFilePath .= $pathParts[$i] . '/';
        }

        return $approvalFilePath . self::APPROVAL_DIR;
    }

    public function getApprovalFileName(string $pathToTestFile, string $testMethodName): string
    {
        return pathinfo($pathToTestFile)['filename'] . '.' . $testMethodName;
    }
}
