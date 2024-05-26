# Validation codes for Laravel
This package adds to the validation error response (422) the key codes that corresponds with validation rules. The response after 
installation looks like this:
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

## Installation
```shell
composer require kdabrow/validation-codes
```

## How does it work?
Extends default \Illuminate\Validation\Validator adding additional checks for commands. Next extends 
\Illuminate\Foundation\Exceptions\Handler to return 'codes' key in the JSON response.

## Configuration

Configuration and language files that contains codes, might be published using Laravel's command:
```shell
php artisan publish --tag=validation_codes
```

### How to return only validation codes?
Change setting `show_only_codes` in the config/validation_codes.php file, to `true`. The response will be changed to:
```json
{
  "codes": {
    "user_id": [
      "E104"
    ]
  }
}
```
Be very cautious, it might be a braking change for your API.

## Troubleshooting 

### Overwrite your own handler