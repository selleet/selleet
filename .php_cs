<?php

use PhpCsFixer\Config;

$config = (new Config('Selleet'))
    ->setRiskyAllowed(true)
    ->setRules([
        '@Symfony' => true,
        'array_syntax' => [
            'syntax' => 'short',
        ],
        'no_unreachable_default_argument_value' => false,
        'braces' => [
            'allow_single_line_closure' => true,
        ],
        'heredoc_to_nowdoc' => false,
        'phpdoc_summary' => false,
    ]);

$config->getFinder()
    ->in([
        __DIR__ . '/src'
    ]);

return $config;
