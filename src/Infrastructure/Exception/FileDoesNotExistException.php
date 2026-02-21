<?php
declare(strict_types=1);

namespace PatrickMaynard\AuditClassGenerator\Infrastructure\Exception;

class FileDoesNotExistException extends \RuntimeException
{
    public function __construct(string $path)
    {
        parent::__construct(
            sprintf('File does not exist: %s', $path)
        );
    }
}
