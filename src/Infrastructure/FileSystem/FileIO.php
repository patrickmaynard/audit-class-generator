<?php
declare(strict_types=1);

namespace PatrickMaynard\AuditClassGenerator\Infrastructure\FileSystem;

use PatrickMaynard\AuditClassGenerator\Infrastructure\Exception\EmptyFileException;
use PatrickMaynard\AuditClassGenerator\Infrastructure\Exception\FileDoesNotExistException;
use PatrickMaynard\AuditClassGenerator\Infrastructure\Exception\FileNotWritableException;

class FileIO
{
    public function read(string $path): string
    {
        if (!file_exists($path)) {
            throw new FileDoesNotExistException("File does not exist: {$path}");
        }

        $contents = file_get_contents($path);

        $hasBom = str_starts_with($contents, "\xEF\xBB\xBF");

        if($contents === '' || ($hasBom && strlen($contents) === 3)) {
            throw new EmptyFileException($path);
        }

        return $contents;
    }

    public function write(string $path, string $content): void
    {
        if (!file_exists($path)) {
            throw new FileDoesNotExistException($path);
        }

        if (!is_writable($path)) {
            throw new FileNotWritableException($path);
        }

        file_put_contents($path, $content);
    }
}
