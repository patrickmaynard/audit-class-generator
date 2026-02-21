<?php
declare(strict_types=1);

namespace PatrickMaynard\AuditClassGenerator\Infrastructure\FileSystem;

class DirectoryScanner
{
    public function scan(string $path): iterable
    {
        $iterator = new \RecursiveIteratorIterator(
            new \RecursiveDirectoryIterator(
                $path,
                \FilesystemIterator::SKIP_DOTS
            )
        );

        foreach ($iterator as $file) {
            if ($file->isFile()) {
                yield $file->getPathname();
            }
        }
    }
}
