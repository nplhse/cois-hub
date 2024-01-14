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
        UserFactory::new(['username' => 'admin'])->asAdmin()->create();

        $this->browser()
            ->loginAs('admin', 'password')
            ->assertLoggedIn()
            ->interceptRedirects()
            ->visit('/admin/area/')
            ->assertRedirectedTo('/admin/area/dispatch')
            ->assertSuccessful()
        ;
    }
}
