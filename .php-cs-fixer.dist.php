<?php

$finder = PhpCsFixer\Finder::create()
    ->name('*.php')
    ->in([__DIR__.'/src', __DIR__.'/tests', __DIR__.'/migrations'])
;

return (new PhpCsFixer\Config())
    ->setRules([
        '@Symfony' => true,
        'phpdoc_align' => false,
        'phpdoc_summary'  => false,
        'phpdoc_separation' => false,
        'php_unit_method_casing' => false, // Disabled, or it will mess our snake case with capital letters
        'visibility_required' => ['elements' => ['property', 'method', 'const']],
        'multiline_whitespace_before_semicolons' => ['strategy' => 'new_line_for_chained_calls'],
        'nullable_type_declaration_for_default_null_value' => false,
    ])
    ->setRiskyAllowed(true)
    ->setUsingCache(true)
    ->setCacheFile(__DIR__.'/.php_cs.cache')
    ->setFinder($finder)
;
