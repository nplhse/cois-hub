<?php

namespace App\Tests\Integration\Controller\Data;

use App\Factory\UserFactory;
use App\Tests\AppWebTestCase;
use Zenstruck\Foundry\Test\Factories;
use Zenstruck\Foundry\Test\ResetDatabase;

class DataControllerTest extends AppWebTestCase
{
    use ResetDatabase;
    use Factories;

    public function testAdminsGetRedirected(): void
    {
        // Act& Assert
        $this->browser()
            ->actingAs(UserFactory::new()->asAdmin()->create()->object())
            ->interceptRedirects()
            ->visit('/data/')
            ->assertRedirectedTo('/data/hospital/')
            ->assertSuccessful()
        ;
    }
}
