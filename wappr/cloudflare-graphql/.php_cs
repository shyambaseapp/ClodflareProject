<?php

$finder = PhpCsFixer\Finder::create()
    ->in('./src')
    ->in('./tests')
;

return PhpCsFixer\Config::create()
    ->setRules([
        '@Symfony' => true,
        'binary_operator_spaces' => ['default' => 'align'],
        'ordered_imports' => ['sort_algorithm' => 'length'],
    ])
    ->setFinder($finder)
;

// "php-cs-fixer.rules": {
//     "@Symfony": true,
//     "binary_operator_spaces": {
//         "default": "align"
//     },
//     "ordered_imports": {
//         "sort_algorithm":"length"
//     }
// }
