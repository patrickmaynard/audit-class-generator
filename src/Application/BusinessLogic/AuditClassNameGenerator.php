<?php

declare(strict_types=1);

namespace PatrickMaynard\AuditClassGenerator;

class AuditClassNameGenerator
{
    protected const AUDIT_CLASS_PREFIX = 'audit';
    protected const RANDOM_STRING_SUFFIX = 'This will provide a nice, long, randomish string.';
    protected const MAX_HASH_LENGTH = 6;
    protected const UPPER_THRESHOLD_RANDOM_INT = 1000000000;

    public static function generate(): string
    {
        return sprintf(
            ' %s_%s ',
            self::AUDIT_CLASS_PREFIX,
            substr(
                md5(random_int(0, self::UPPER_THRESHOLD_RANDOM_INT) . self::RANDOM_STRING_SUFFIX),
                0,
                self::MAX_HASH_LENGTH
            )
        );
    }
}
