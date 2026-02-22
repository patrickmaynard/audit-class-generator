<?php

namespace PatrickMaynard\AuditClassGenerator\Tests\Application\BusinessLogic;

use PatrickMaynard\AuditClassGenerator\Application\BusinessLogic\Applier;
use PatrickMaynard\AuditClassGenerator\Application\BusinessLogic\AuditClassNameGenerator;
use PHPUnit\Framework\TestCase;

class ApplierTest extends TestCase
{
    protected const AUDIT_CLASS_PREFIX = 'audit_';

    public function testSingleClassInjection(): void
    {
        $applier = new Applier();

        $input = '<div class="foo"></div>';
        $output = $applier->applyAllAuditTags($input);

        $this->assertMatchesRegularExpression('/class="foo audit_[0-9a-f]{6} "/', $output);
    }
    public function testReRunSingleClassInjection(): void
    {
        $applier = new Applier();

        $input = '<div class="foo' . AuditClassNameGenerator::generate() . '"></div>';
        $output = $applier->applyAllAuditTags($input);

        $this->assertMatchesRegularExpression('/class="foo audit_[0-9a-f]{6} "/', $output);
    }

    public function testMultipleClasses(): void
    {
        $applier = new Applier();

        $input = '<div class="foo"></div><span class="bar baz"></span>';
        $output = $applier->applyAllAuditTags($input);

        $this->assertMatchesRegularExpression('/class="foo audit_[0-9a-f]{6} "/', $output);
        $this->assertMatchesRegularExpression('/class="bar baz audit_[0-9a-f]{6} "/', $output);
    }

    public function testNoClassTags(): void
    {
        $applier = new Applier();
        $input = '<div></div>';
        $this->assertEquals($input, $applier->applyAllAuditTags($input));
    }

    public function testEmptyClassAttribute(): void
    {
        $applier = new Applier();
        $input = '<div class=""></div>';
        $output = $applier->applyAllAuditTags($input);

        $this->assertMatchesRegularExpression('/class=" audit_[0-9a-f]{6} "/', $output);
    }
}
