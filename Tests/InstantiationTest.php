<?php

namespace PatrickMaynard\AuditClassGenerator\Tests;

use PatrickMaynard\AuditClassGenerator\src\Applier;
use PHPUnit\Framework\TestCase;

class InstantiationTest extends TestCase
{
    public function testInstantiation(): void
    {
        $applier = new Applier;

        //If there were no excpetions, we're good for now.
        self::assertTrue(true);
    }
}
