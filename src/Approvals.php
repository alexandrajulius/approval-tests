<?php

declare(strict_types=1);

namespace AHJ\ApprovalTests;

use PHPUnit\Framework\Assert;

final class Approvals
{
    protected FileHandler $fileHandler;
    protected FilePathResolver $filePathResolver;
    protected ReceivedMap $receiveMap;

    public function __construct(
        FileHandler $fileHandler,
        FilePathResolver $filePathResolver,
        ReceivedMap $receiveMap
    ) {
        $this->fileHandler = $fileHandler;
        $this->filePathResolver = $filePathResolver;
        $this->receiveMap = $receiveMap;
    }

    public static function create(): self
    {
        return new self(
            new FileHandler(),
            new FilePathResolver(),
            new ReceivedMap()
        );
    }

    public function verifyList(array $input, array $output): void
    {
        $filePathResolved = $this->filePathResolver->resolve();
        $received = $this->receiveMap->create($input, $output);

        # always create the received file
        $this->fileHandler->placeFile(
            $filePathResolved->getDirPath(),
            $filePathResolved->getReceivedName(),
            $received
        );

        # only create the approved file if it does not exist
        if (!file_exists($filePathResolved->getApprovedFile())) {
            $this->fileHandler->placeFile(
                $filePathResolved->getDirPath(),
                $filePathResolved->getApprovedName(),
                null
            );
        }

        self::verify($received, $filePathResolved);
    }

    private function verify(string $received, FilePathResolverResult $filePathResolved): void
    {
        $approved = file_get_contents($filePathResolved->getApprovedFile());

        Assert::assertEquals(
            trim($approved),
            trim($received),
            'To approve run: mv ' . $filePathResolved->getReceivedFile() . ' ' . $filePathResolved->getApprovedFile()
        );

        $this->fileHandler->deleteReceived($filePathResolved);
    }
}
