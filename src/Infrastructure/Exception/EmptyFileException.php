<?php
declare(strict_types=1);

namespace PatrickMaynard\AuditClassGenerator\Infrastructure\Exception;

class EmptyFileException extends \RuntimeException
{
    public function __construct(string $path)
    {
        parent::__construct(
            sprintf('File is empty: %s', $path)
        );
    }
}
