<?php

$finder = (new PhpCsFixer\Finder())
    ->in(__DIR__)
    ->exclude('node_modules')
    ->exclude('var')
;

return (new PhpCsFixer\Config())
    ->setRules([
        '@Symfony' => true,
        '@PHP82Migration' => true,
        'array_syntax' => ['syntax' => 'short'],
    ])
    ->setFinder($finder)
;
