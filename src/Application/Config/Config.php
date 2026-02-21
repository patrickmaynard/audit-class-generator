<?php

declare(strict_types=1);

namespace PatrickMaynard\AuditClassGenerator\Application\Config;

class Config
{
    private string $directory;
    private string $extension;
    private bool $verbose;

    private function __construct(
        string $directory,
        string $extension,
        bool $verbose
    ) {
        $this->directory = $directory;
        $this->extension = $extension;
        $this->verbose = $verbose;
    }

    public static function create(array $options): self
    {
        return new self(
            $options['directory'] ?? $options['d'] ?? 'templates',
            $options['extension'] ?? $options['e'] ?? 'html.twig',
            isset($options['v']) || isset($options['verbose'])
        );
    }

    public function getDirectory(): string
    {
        return $this->directory;
    }

    public function getExtension(): string
    {
        return $this->extension;
    }

    public function isVerbose(): bool
    {
        return $this->verbose;
    }
}
