<?php

namespace Kdabrow\ValidationCodes\Tests;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class CustomRuleWithoutCode implements ValidationRule
{
	public function validate(string $attribute, mixed $value, Closure $fail): void
	{
		$fail("Failed validation rule");
	}
}