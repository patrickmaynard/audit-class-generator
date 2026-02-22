<?php

namespace PatrickMaynard\AuditClassGenerator\Tests\Application\BusinessLogic;

use PatrickMaynard\AuditClassGenerator\Application\BusinessLogic\Applier;
use PHPUnit\Framework\TestCase;

class InstantiationTest extends TestCase
{
    public function testInstantiation(): void
    {
        $applier = new Applier();

        //If there were no excpetions, we're good for now.
        self::assertTrue(true);
    }
}
