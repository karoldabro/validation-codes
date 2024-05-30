<?php

namespace Kdabrow\ValidationCodes\Tests\Helpers;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class CustomRule implements ValidationRule
{
	public function validate(string $attribute, mixed $value, Closure $fail): void
	{
		$fail("Failed validation rule");
	}

	public static function getCode(): string
	{
		return 'E10000';
	}
}