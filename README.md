[![Maintainability Rating](https://sonarcloud.io/api/project_badges/measure?project=beeblebrox3_caster&metric=sqale_rating)](https://sonarcloud.io/summary/new_code?id=beeblebrox3_caster)
[![Security Rating](https://sonarcloud.io/api/project_badges/measure?project=beeblebrox3_caster&metric=security_rating)](https://sonarcloud.io/summary/new_code?id=beeblebrox3_caster)
[![Vulnerabilities](https://sonarcloud.io/api/project_badges/measure?project=beeblebrox3_caster&metric=vulnerabilities)](https://sonarcloud.io/summary/new_code?id=beeblebrox3_caster)
[![Coverage](https://sonarcloud.io/api/project_badges/measure?project=beeblebrox3_caster&metric=coverage)](https://sonarcloud.io/summary/new_code?id=beeblebrox3_caster)

# Caster

PHP Library to cast arrays of values

## Requirements

- PHP 7

## Usage

Basic example:

```php
$types = [
    'must_be_integer' => 'integer',
];
$input = [
    'must_be_integer' => '0.9',
];

$caster = new Beeblebrox3\Caster\Caster();
$res = $caster->cast($types, $input);

// $res will be ['must_be_integer' => 0]

```

The `$types` parameter specifies how the `$input` values should be transformed.
You do this specifying an array of rules to be applyied. A rule is identified by a string.

```php
$types = [
    'a' => 'integer',
    'b' => 'string',
    'c' => 'bool',
]
```

You can also apply multiple rules to the same value:

```php
$types = [
    'a' => 'integer',
    'b' => 'string|lpad:10,0', // will cast to string and after apply a left string pad
]
```

Rules can have arguments:

```php
$types = [
    // string up to 60 characters
    'a' => 'string:60',

    // will cast to float and then round with precision of two specifying the mode in which rounding occurs
    // (see https://php.net/round for details)
    'b' => 'float:2,' . PHP_ROUND_HALF_DOWN,
];
```

You can use nested arrays too:

```php
$res = $caster->cast(
    ['level1.level2.level3.key' => 'integer'],
    ['level1' => ['level2' => ['level3' => ['key' => '999']]]]
);

// $res wil be ['level1' => ['level2' => ['level3' => ['key' => 999]]]]
```

### Available rules

> to pass options you don't use their names, but pass the values in the displayed order. Example: ` 'a' => 'bool|1'`.
> arguments with `*` are mandatory

| Rule        | Arguments                              | Details                                                                                                      |
|-------------|----------------------------------------|--------------------------------------------------------------------------------------------------------------|
| bool        | `nullIfEmpty`*                         | cast to boolean. If `nullIfEmpty` is `1`, cast empty strings and null to null, else cast to `false`          |
| date_format | `output format`* <br /> `input format` | format the given date to an specific format. You can also specify the format of the input date               |
| float       | `precision` <br /> `round mode`        | cast to float and optionally round the value using `precision` and `round mode` (using the `round` function) |
| integer     |                                        | cast to integer                                                                                              |
| lpad        | `length` * <br /> `str` *              | pad the string on the left site to `length` length using `str` to fill                                       |
| rpad        | `length` * <br /> `str` *              | pad the string on the right site to `length` length using `str` to fill                                      |
| string      | `max length`                           | casto so string, optionally limiting the string size to `max length` (using `substr`)                        |


### Custom Rules

You can create your own rules with a class implementing the `Beeblebrox3\Caster\Rules\IRule` interface:

```php
<?php

use Beeblebrox3\Caster\Rules\IRule;
use Beeblebrox3\Caster\Caster;

class PipeRule implements IRule {
  public function handle($value, ...$args) {
    return $value;
  }
}

$caster = new Caster();
$caster->addCustomRule('pipe', PipeRule::class);

$res = $caster->cast(['a' => 'pipe'], ['a' => '199']);
```

The `PipeRule` will only return the same input.

#### Function as custom  rule
> new on version `0.1.0`

```php
$caster = new Caster();
$caster->addCustomrule('pipe', function ($value) { return $value; });
```

Now you created the same pipe rule as before, but without the class.

## Changelog
- `0.1.0` Add support functions as custom rules;
- `0.0.2` Add custom rules support;

