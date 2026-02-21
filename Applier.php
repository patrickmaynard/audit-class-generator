<?php

namespace PatrickMaynard\AuditClassGenerator;

class Applier
{
    public function applyAllAuditTags(string $contents): string
    {
        preg_match_all('/class="[^"]*"/', $contents, $matches);

        foreach ($matches as $match) {
            if (!is_array($match)) {
                continue;
            }

            foreach ($match as $matchingString) {
                if (str_contains($matchingString, 'audit_')) {
                    continue;
                }

                $withSpace = AuditClassNameGenerator::generate();

                //Now just do a simple string replacement
                $contents = str_replace(
                    $matchingString,
                    substr($matchingString, 0, -1) . $withSpace . '"',
                    $contents,
                );
            }
        }

        return $contents;
    }
}
