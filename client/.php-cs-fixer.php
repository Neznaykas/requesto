<?php

return (new PhpCsFixer\Config())
    ->setRules([
        '@PHP82Migration' => true,
        '@PSR12' => true,
        '@DoctrineAnnotation' => true,
        '@PSR12:risky' => true,
        '@PHPUnit84Migration:risky' => true,
        // Each line of multi-line DocComments must have an asterisk [PSR-5] and must be aligned with the first one.
        '@PHP83Migration' => true,
        // Each line of multi-line DocComments must have an asterisk [PSR-5] and must be aligned with the first one.
        'align_multiline_comment' => true,
        // Each element of an array must be indented exactly once.
        'array_indentation' => true,
        'method_chaining_indentation' => true,
        // Binary operators should be surrounded by space as configured.
        'binary_operator_spaces' => true,
        // A single space or none should be between cast and variable.
        'cast_spaces' => true,
        // When referencing an internal class it must be written using the correct casing.
        'class_reference_name_casing' => true,
        // Namespace must not contain spacing, comments or PHPDoc.
        'clean_namespace' => true,
        // Calling `unset` on multiple items should be done in one call.
        'combine_consecutive_unsets' => true,
        // Concatenation should be spaced according configuration.
        'concat_space' => ['spacing' => 'one'],
        // Forbid multi-line whitespace before the closing semicolon or move the semicolon to the new line for chained calls.
        'multiline_whitespace_before_semicolons' => ['strategy' => 'new_line_for_chained_calls'],
        // There should not be empty PHPDoc blocks.
        'no_empty_phpdoc' => true,
        // Removes extra blank lines and/or blank lines following configuration.
        'no_extra_blank_lines' => [
            'tokens' => ['attribute', 'case', 'continue', 'curly_brace_block', 'default', 'extra', 'parenthesis_brace_block', 'square_brace_block', 'switch', 'throw', 'use']
        ],
        // Removes `@param`, `@return` and `@var` tags that don't provide any useful information.
        'no_superfluous_phpdoc_tags' => ['allow_mixed' => true, 'remove_inheritdoc' => true],
        // Logical NOT operators (`!`) should have leading and trailing whitespaces.
        'not_operator_with_space' => false,
        // Ordering `use` statements.
        'ordered_imports' => true,
        // PHPDoc should start and end with content, excluding the very first and last line of the docblocks.
        'phpdoc_trim' => true,
        // Sorts PHPDoc types.
        'phpdoc_types_order' => ['null_adjustment' => 'always_last'],
        // Arrays should be formatted like function/method arguments, without leading or trailing single line space.
        'trim_array_spaces' => true,
        // A single space or none should be around union type and intersection type operators.
        'types_spaces' => true,
        'no_unused_imports' => true,
        // In array declaration, there MUST be a whitespace after each comma.
        'whitespace_after_comma_in_array' => ['ensure_single_space' => true],
        'method_argument_space' => [
            'on_multiline' => 'ensure_fully_multiline',
            'keep_multiple_spaces_after_comma' => true,
        ],
        'single_line_after_imports' => true,
        'trailing_comma_in_multiline' => [
            'elements' => [
                'arguments',
                'arrays',
                'match',
                'parameters',
            ],
        ],
        'class_attributes_separation' => [
            'elements' => [
                'const' => 'none',
                'method' => 'one',
                'property' => 'none',
                'trait_import' => 'none',
                'case' => 'none',
            ],],
        'single_line_throw' => false,
    ])
    ->setFinder(
        (new PhpCsFixer\Finder())
            ->in([
                __DIR__ . '/src',
                __DIR__ . '/tests',
            ])
    )
    ->setRiskyAllowed(true);
