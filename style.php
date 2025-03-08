<?php

$finder = Symfony\Component\Finder\Finder::create()
    ->in([
        __DIR__,
    ])
    ->name('*.php')
    ->ignoreDotFiles(true)
    ->ignoreVCS(true);

return (new PhpCsFixer\Config())
    ->setRules([
        '@PSR12' => true,
        'strict_param' => true,
        'array_syntax' => ['syntax' => 'short'],
        'ordered_imports' => [
            'sort_algorithm' => 'length',
            'imports_order' => ['const', 'class', 'function'],
        ],
    ])
    ->setFinder($finder);
