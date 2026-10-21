<?php

namespace Tingo\Translatable\Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Group;
use Tingo\Translatable\Models\Translation;
use Tingo\Translatable\Tests\TestCase;

class UpdateTranslationsTest extends TestCase
{
    use RefreshDatabase;

    #[Group('default')]
    public function testUpdateTranslation()
    {
        $entity = $this->createTestEntity();
        $entity->createTranslation('name', 'Meine Entität', 'de');
        $this->assertSame('Meine Entität', $entity->getTranslation('name', 'de'));

        $this->assertTrue($entity->updateTranslation('name', 'Meine aktualisierte Entität', 'de'));
        $this->assertSame('Meine aktualisierte Entität', $entity->getTranslation('name', 'de'));

        $this->assertFalse($entity->updateTranslation('name', 'Mon entité nouveaux', 'fr'));
    }
}