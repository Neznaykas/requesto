<?php

return (new PhpCsFixer\Config())
    ->setRules([
        '@PHP81Migration' => true,
        '@PSR12' => true,
        '@DoctrineAnnotation' => true,
        '@PSR12:risky' => true,
        '@PHPUnit84Migration:risky' => true,
        // Each line of multi-line DocComments must have an asterisk [PSR-5] and must be aligned with the first one.
        'align_multiline_comment' => true,
        // Each element of an array must be indented exactly once.
        'array_indentation' => true,
        // Converts simple usages of `array_push($x, $y);` to `$x[] = $y;`.
        'array_push' => true,
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
        // Imports or fully qualifies global classes/functions/constants.
        'global_namespace_import' => true,
        // Forbid multi-line whitespace before the closing semicolon or move the semicolon to the new line for chained calls.
        'multiline_whitespace_before_semicolons' => ['strategy' => 'no_multi_line'],
        // There should not be empty PHPDoc blocks.
        'no_empty_phpdoc' => true,
        // Removes extra blank lines and/or blank lines following configuration.
        'no_extra_blank_lines' => true,
        // Removes `@param`, `@return` and `@var` tags that don't provide any useful information.
        'no_superfluous_phpdoc_tags' => ['allow_mixed' => true, 'remove_inheritdoc' => true],
        // Logical NOT operators (`!`) should have leading and trailing whitespaces.
        'not_operator_with_space' => false,
        // Ordering `use` statements.
        'ordered_imports' => true,
        // Calls to `PHPUnit\Framework\TestCase` static methods must all be of the same type, either `$this->`, `self::` or `static::`.
        'php_unit_test_case_static_method_calls' => ['call_type' => 'self'],
        // PHPDoc should start and end with content, excluding the very first and last line of the docblocks.
        'phpdoc_trim' => true,
        // Sorts PHPDoc types.
        'phpdoc_types_order' => ['null_adjustment' => 'always_last'],
        // Lambdas not (indirect) referencing `$this` must be declared `static`.
        'static_lambda' => true,
        // Functions should be used with `$strict` param set to `true`.
        'strict_param' => true,
        // Arrays should be formatted like function/method arguments, without leading or trailing single line space.
        'trim_array_spaces' => true,
        // A single space or none should be around union type and intersection type operators.
        'types_spaces' => true,
        // Anonymous functions with one-liner return statement must use arrow functions.
        'use_arrow_functions' => true,
        // Add `void` return type to functions with missing or empty return statements, but priority is given to `@return` annotations. Requires PHP >= 7.1.
        'void_return' => true,
        'no_unused_imports' => true,
        // In array declaration, there MUST be a whitespace after each comma.
        'whitespace_after_comma_in_array' => ['ensure_single_space' => true],
    ])
    ->setFinder(
        (new PhpCsFixer\Finder())
            ->in([
                __DIR__ . '/src',
                __DIR__ . '/tests',
            ])
    )
    ->setRiskyAllowed(true);
