<?php

namespace PatrickMaynard\AuditClassGenerator;

class Applier
{
    public function applyAllAuditTags(string $contents): string
    {
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

        return $contents;
    }
}
