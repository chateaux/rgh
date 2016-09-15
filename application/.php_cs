<?php
$finder = Symfony\CS\Finder\DefaultFinder::create()
    ->name('*.php.dist')
    ->in('config')
    ->in('module')
    ->in('public')
    ->filter(function (SplFileInfo $file) {
        if (strstr($file->getPath(), 'compatibility')) {
            return false;
        }
    });
$config = Symfony\CS\Config\Config::create();
$config->setUsingCache(true);
$config->level(Symfony\CS\FixerInterface::PSR2_LEVEL);
$config->fixers(
    array(
        'braces',
        'duplicate_semicolon',
        'elseif',
        'empty_return',
        'encoding',
        'eof_ending',
        'function_call_space',
        'function_declaration',
        'indentation',
        'join_function',
        'line_after_namespace',
        'linefeed',
        'lowercase_constants',
        'lowercase_keywords',
        'parenthesis',
        'multiple_use',
        'method_argument_space',
        'newline_after_open_tag',
        'object_operator',
        'ordered_use',
        'php_closing_tag',
        'remove_lines_between_uses',
        'short_array_syntax',
        'short_tag',
        'standardize_not_equal',
        'trailing_spaces',
        'unused_use',
        'visibility',
        'whitespacy_lines',
    )
);
$config->finder($finder);
return $config;
