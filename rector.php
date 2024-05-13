<?php

declare(strict_types=1);

use Rector\Config\RectorConfig;
use Rector\PHPUnit\AnnotationsToAttributes\Rector\ClassMethod\DataProviderAnnotationToAttributeRector;

return RectorConfig::configure()
    ->withPreparedSets(codeQuality: true, codingStyle: true)
    ->withAttributesSets(symfony: true, doctrine: true, phpunit: true)
    ->withPhpSets()
    ->withRootFiles()
    ->withPaths([
        __DIR__.'/src',
        __DIR__.'/tests',
    ])
    ->withSkip([
        DataProviderAnnotationToAttributeRector::class => [
            __DIR__.'/tests',
        ],
    ])
    ->withSymfonyContainerXml(__DIR__.'/var/cache/dev/App_KernelDevDebugContainer.xml')
    ->withSymfonyContainerPhp(__DIR__.'/tests/symfony-container.php')
;
