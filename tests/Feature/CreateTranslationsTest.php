<?php

namespace Tingo\Translatable\Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Group;
use Tingo\Translatable\Exceptions\AttributeNotFoundException;
use Tingo\Translatable\Exceptions\AttributeNotTranslatableException;
use Tingo\Translatable\Tests\TestCase;


class CreateTranslationsTest extends TestCase
{
    use RefreshDatabase;

    #[Group('default')]
    public function testAttributeNotFound()
    {
        $this->expectException(AttributeNotFoundException::class);
        $this->createTestEntity()->createTranslation('unknown', 'Meine Entität', 'de');
    }

    #[Group('default')]
    public function testAttributeNotTranslatable()
    {
        $this->expectException(AttributeNotTranslatableException::class);
        $this->createTestEntity()->createTranslation('unit', 'Pfund', 'de');
    }

    #[Group('default')]
    public function testSuccessfulWithLocale()
    {
        $translation = $this->createTestEntity()->createTranslation('name', 'Meine Entität', 'de');
        $this->assertSame($translation->attribute, 'name');
        $this->assertSame($translation->value, 'Meine Entität');
        $this->assertSame($translation->locale, 'de');
    }
}