<?php

namespace App;

use App\DependencyInjection\AppExtension;
use Symfony\Bundle\FrameworkBundle\Kernel\MicroKernelTrait;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Kernel as BaseKernel;

class Kernel extends BaseKernel
{
    use MicroKernelTrait;

    protected function prepareContainer(ContainerBuilder $container): void
    {
        $container->registerExtension(new AppExtension());

        parent::prepareContainer($container);
    }
}
