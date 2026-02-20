<?php

namespace PatrickMaynard\AuditClassGenerator;

class Applier
{
    private Config $config;

    public function __construct(Config $config)
    {
        $this->config = $config;
    }

    public function applyAllAuditTags(): void
    {
        $files = $this->filterAllFilesForTwigExtension();

        foreach ($files as $index => $file) {
            $contents = file_get_contents($file);
            preg_match_all('/class="[^"]+"/', $contents, $matches);

            foreach ($matches as $index => $match) {
                if ($index = 0) {
                    continue;
                }

                if (is_array($match)) {
                    foreach ($match as $matchingString) {
                        $hash = md5(rand(0, 1000000000) . "This will provide a nice, long, randomish string.");
                        $shorterFingerprint = 'audit_' . substr($hash, 0, 6);
                        $withSpace = ' ' . $shorterFingerprint . ' ';

                        //Now just do a simple string replacement
                        $contents = str_replace(
                            $matchingString,
                            substr($matchingString, 0, -1) . $withSpace . '"',
                            $contents,
                        );
                    }
                }
            }

            file_put_contents($file, $contents);
        }

        echo "Done!";
        echo PHP_EOL;
    }

    //TODO: Allow blade as well. Maybe solved with configuration
    private function filterAllFilesForTwigExtension(): array
    {
        $directoryToParse = getcwd() . DIRECTORY_SEPARATOR . $this->config->getDirectory();

        echo PHP_EOL . 'We will be looking recursively in ' . $directoryToParse . ' for Twig files .. ' . PHP_EOL;

        $files = $this->getDirContents($directoryToParse);
        $output = [];

        foreach ($files as $file) {
            if (str_ends_with($file, $this->config->getExtension())) {
                $output[] = $file;
            }
        }

        return $output;
    }

    private function getDirContents($dir): array
    {
        $results = [];
        $files = scandir($dir);

        foreach ($files as $key => $value) {
            if (!is_dir($dir . DIRECTORY_SEPARATOR . $value)) {
                $results[] = $dir . DIRECTORY_SEPARATOR . $value;
            } elseif (
                is_dir($dir . DIRECTORY_SEPARATOR . $value)
                && !str_contains($value, '..')
                && $value !== '.'
            ) {
                $results[] = $value;
                $results = array_merge($results, $this->getDirContents($dir . DIRECTORY_SEPARATOR . $value));
            }
        }

        return $results;
    }
}
