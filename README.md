<p align="center">
<img alt="GitHub Workflow Status (branch)" src="https://github.com/karoldabro/validation-codes/actions/workflows/laravel.yml/badge.svg">
<img alt="Packagist Version" src="https://img.shields.io/packagist/v/kdabrow/validation-codes">
<img alt="Packagist Downloads" src="https://img.shields.io/packagist/dm/kdabrow/validation-codes">
<img alt="Scrutinizer code quality (GitHub/Bitbucket)" src="https://img.shields.io/scrutinizer/quality/g/karoldabro/validation-codes/master">
</p>

# Validation Codes for Laravel

This package enhances Laravel's validation error responses (status 422) by adding corresponding validation rule codes. After installation, the response format is as follows:

```json
{
  "message": "validation errors",
  "errors": {
    "user_id": [
      "Field user_id is required"
    ]
  },
  "codes": {
    "user_id": [
      "E104"
    ]
  }
}
```
Error codes allow clients of your API to easily interpret returned validation errors in the way they want or need. 

## Installation

First, install the package using Composer:

| PHP  | Laravel | Package                                                           | Command                                                  |
|------|---------|-------------------------------------------------------------------|----------------------------------------------------------|
| ^8.3 | 12      | 3.0                                                               | ```composer require "kdabrow/validation-codes: ^3.1"```  |
| ^8.2 | 11      | 2.0                                                               | ```composer require "kdabrow/validation-codes: ^2.0"```  |
| ^8.1 | 10      | [1.1](https://github.com/karoldabro/validation-codes/tree/v1.1.0) | ```composer require "kdabrow/validation-codes: ^1.1" ``` |

## How It Works

This package extends Laravel's default validation system by overwriting the default Handler to return the correct JSON response.

## Configuration

### Overwriting Validation Codes

To publish the configuration and language files containing the codes, use Laravel's command:

```shell
php artisan vendor:publish --tag=validation_codes
```

You can then change the validation codes corresponding to the given rules in the published file, which looks like this:

```php
<?php

return [
    'fallback_error' => 'E0', // This error code is returned when an error code isn't found in this file
    'accepted' => 'E1',
    'accepted_if' => 'E2',
    'active_url' => 'E3',
    // ...
];
```

### Returning Only Validation Codes (Without Messages)

To return only validation codes, set `show_only_codes` to `true` in the `config/validation_codes.php` file. The response will be:

```json
{
  "codes": {
    "user_id": [
      "E104"
    ]
  }
}
```

**Caution:** This might be a breaking change for your API.

**Ensure your `Exception\Handler` extends `Kdabrow\ValidationCodes\Handler`.**

### Adding an Error Code to Custom Validation Rules

Add a static method `getCode` to your custom validation rule. For example:

```php
<?php

use Illuminate\Contracts\Validation\ValidationRule;

class YourCustomValidationRule implements ValidationRule
{
    public function validate(string $attribute, mixed $value, \Closure $fail): void
    {
        // validation logic
    }

    public static function getCode(): string
    {
        return 'E10000'; // The validation code to return
    }
}
```

### Adding an Error Code to a Validation Rule that Extends Validator

Add a fourth parameter to the `extend` function:

```php
<?php

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;

class YourServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        Validator::extend('your_rule', YourRule::class, 'message', 'E10000');
    }
}
```

### Adding an Error Code to an Anonymous Validation Function

This is not supported.

## Testing

To run tests, use the following command:

```shell
docker compose exec php vendor/bin/phpunit
```
