<?php

declare(strict_types=1);

namespace PatrickMaynard\AuditClassGenerator\Infrastructure\Exception;

class FileNotWritableException extends \RuntimeException
{
    public function __construct(string $path)
    {
        parent::__construct(
            sprintf('File not writable: %s', $path)
        );
    }
}
