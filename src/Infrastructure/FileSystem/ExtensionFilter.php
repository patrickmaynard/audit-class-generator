<?php
declare(strict_types=1);

namespace PatrickMaynard\AuditClassGenerator\Infrastructure\FileSystem;

class ExtensionFilter
{
    public function __construct(private string $extension) {}

    public function matches(string $filePath): bool
    {
        return pathinfo($filePath, PATHINFO_EXTENSION) === $this->extension;
    }
}
