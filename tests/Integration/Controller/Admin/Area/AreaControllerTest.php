<?php

namespace App\Tests\Integration\Controller\Admin\Area;

use App\Factory\UserFactory;
use App\Tests\AppWebTestCase;
use Zenstruck\Foundry\Test\Factories;
use Zenstruck\Foundry\Test\ResetDatabase;

class AreaControllerTest extends AppWebTestCase
{
    use ResetDatabase;
    use Factories;

    public function testAdminsGetRedirected(): void
    {
        // Act& Assert
        $this->browser()
            ->actingAs(UserFactory::new()->asAdmin()->create()->object())
            ->interceptRedirects()
            ->visit('/admin/area/')
            ->assertRedirectedTo('/admin/area/dispatch')
            ->assertSuccessful()
        ;
    }
}
