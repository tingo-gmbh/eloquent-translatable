<?php

namespace Tingo\Translatable\Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\App;
use PHPUnit\Framework\Attributes\Group;
use Tingo\Translatable\Tests\TestCase;

class GetTranslationsTest extends TestCase
{
    use RefreshDatabase;

    #[Group('default')]
    public function testAttributeNotTranslatable()
    {
        $entity = $this->createTestEntity();
        $entity->createTranslation('name', 'Meine Entität', 'de');

        $this->assertNull($entity->getTranslation('foo'));
    }

    #[Group('default')]
    public function testDefaultValue()
    {
        $entity = $this->createTestEntity();
        $this->assertSame('Foo entity', $entity->getTranslation('name'));
        $this->assertSame('pounds', $entity->getTranslation('unit'));
    }

    #[Group('default')]
    public function testSuccessfulWithLocale()
    {
        $entity = $this->createTestEntity();
        $entity->createTranslation('name', 'Meine Entität', 'de');

        $this->assertSame('Meine Entität', $entity->getTranslation('name', 'de'));
    }

    #[Group('default')]
    public function testSuccessfulWithoutLocale()
    {
        $entity = $this->createTestEntity();
        $entity->createTranslation('name', 'Meine Entität', 'de');

        App::setLocale('de');
        $this->assertSame('Meine Entität', $entity->getTranslation('name'));
    }

    #[Group('default')]
    public function testGetAllTranslations()
    {
        $entity = $this->createTestEntity();
        $entity->createTranslation('name', 'Meine Entität', 'de');
        $entity->createTranslation('name', 'Mon entité', 'fr');

        $translations = $entity->getTranslations();
        $this->assertSame('Foo entity', $translations['name']['default']);
        $this->assertSame('Meine Entität', $translations['name']['de']);
        $this->assertSame('Mon entité', $translations['name']['fr']);
    }
}