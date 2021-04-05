<?php

declare(strict_types=1);

namespace AHJ\ApprovalTests;

use Exception;

final class FilePathResolver
{
    public const APPROVAL_DIR = 'approval';

    public function resolve(): FilePathResolverResult
    {
        [$pathToTestFile, $testMethodName] = $this->getTestPathAndMethodName();

        $approvalFilePath = $this->getApprovalFilePath($pathToTestFile);
        $approvalFileName = $this->getApprovalFileName($pathToTestFile, $testMethodName);

        return new FilePathResolverResult($approvalFilePath, $approvalFileName);
    }

    public function getApprovalFilePath(string $pathToTestFile): string
    {
        $pathParts = explode('/', pathinfo($pathToTestFile)['dirname']);
        $flip = array_flip($pathParts);
        // TODO: guard from undefined index
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

    public function getTestPathAndMethodName(): array
    {
        $traces = debug_backtrace(1);

        foreach ($traces as $key => $trace) {
            if ($this->endsWith($trace['file'], 'Test.php', true)) {
                $pathToTestFile = $trace['file'];
                $testMethodName = $traces[$key + 1]['function'];

                return [$pathToTestFile, $testMethodName];
            }
        }

        throw new Exception(sprintf(
            'Failed to identify the testing file or method you are using.'
        ));
    }

    private function endsWith(string $haystack, string $needle, $ignoreCase = false): bool
    {
        if ($ignoreCase) {
            $haystack = mb_strtolower($haystack);
            $needle = mb_strtolower($needle);
        }

        return mb_substr($haystack, mb_strlen($haystack) - mb_strlen($needle)) === $needle;
    }
}
