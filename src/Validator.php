<?php

namespace Kdabrow\ValidationCodes;

use Illuminate\Support\MessageBag;
use Illuminate\Support\Str;

class Validator extends \Illuminate\Validation\Validator
{
	private MessageBag $codes;

	public function getCodes(): MessageBag
	{
		return $this->codes;
	}

	/**
	 * Determine if the data passes the validation rules.
	 *
	 * @return bool
	 */
	public function passes()
	{
		$this->codes = new MessageBag; // TODO: test

		return parent::passes();
	}

	/**
	 * Overwrite
	 *
	 * @param  string  $attribute
	 * @param  string  $rule
	 * @param  array  $parameters
	 * @return void
	 */
	public function addFailure($attribute, $rule, $parameters = [])
	{
		if (! $this->messages) {
			$this->passes();
		}

		$attributeWithPlaceholders = $attribute;

		$attribute = $this->replacePlaceholderInString($attribute);

		if (in_array($rule, $this->excludeRules)) {
			return $this->excludeAttribute($attribute);
		}

		$this->messages->add($attribute, $this->makeReplacements(
			$this->getMessage($attributeWithPlaceholders, $rule), $attribute, $rule, $parameters
		));

		$this->codes->add($attribute, $this->findErrorCode($rule)); // TODO: test

		$this->failedRules[$attribute][$rule] = $parameters;
	}

	protected function findErrorCode(string $rule): string
	{
		$lowerRule = Str::snake($rule);

		$key = "validation_codes::codes.{$lowerRule}";

		if ($key !== ($value = $this->translator->get($key))) { // TODO: test
			return $value;
		}

		return 'E0'; // TODO: test
	}
}