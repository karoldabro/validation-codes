<?php

namespace Kdabrow\ValidationCodes;

use Illuminate\Contracts\Validation\DataAwareRule;
use Illuminate\Contracts\Validation\ValidatorAwareRule;
use Illuminate\Support\MessageBag;
use Illuminate\Support\Str;
use Illuminate\Validation\InvokableValidationRule;

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

		$this->codes->add($attribute, $this->findErrorCode($attribute, $rule)); // TODO: test

		$this->failedRules[$attribute][$rule] = $parameters;
	}

	/**
	 * Validate an attribute using a custom rule object.
	 *
	 * @param  string  $attribute
	 * @param  mixed  $value
	 * @param  \Illuminate\Contracts\Validation\Rule  $rule
	 * @return void
	 */
	protected function validateUsingCustomRule($attribute, $value, $rule)
	{
		$attribute = $this->replacePlaceholderInString($attribute);

		$value = is_array($value) ? $this->replacePlaceholders($value) : $value;

		if ($rule instanceof ValidatorAwareRule) {
			$rule->setValidator($this);
		}

		if ($rule instanceof DataAwareRule) {
			$rule->setData($this->data);
		}

		if (! $rule->passes($attribute, $value)) {
			$ruleClass = $rule instanceof InvokableValidationRule ?
				get_class($rule->invokable()) :
				get_class($rule);

			$this->failedRules[$attribute][$ruleClass] = [];

			$messages = $this->getFromLocalArray($attribute, $ruleClass) ?? $rule->message();

			$messages = $messages ? (array) $messages : [$ruleClass];

			foreach ($messages as $key => $message) {
				$key = is_string($key) ? $key : $attribute;

				$this->messages->add($key, $this->makeReplacements(
					$message, $key, $ruleClass, []
				));

				$this->codes->add(
					$attribute,
					method_exists($ruleClass, 'getCode') ? $ruleClass::getCode($attribute) : $this->fallbackTranslation(), // TODO: change E0 to translation
				); // TODO: test
			}
		}
	}

	protected function findErrorCode($attribute, string $rule): string
	{
		$lowerRule = Str::snake($rule);

		$key = $this->getKey($lowerRule);

		if ($key !== ($this->getTranslation($lowerRule))) { // TODO: test
			return $this->getCustomMessageFromTranslator(
				in_array($rule, $this->sizeRules)
					? [$key.".{$this->getAttributeType($attribute)}", $key]
					: $key
			);
		}

		return $this->fallbackTranslation(); // TODO: test
	}

	private function fallbackTranslation(): string|array
	{
		return $this->getTranslation("fallback_error");
	}

	private function getTranslation(string $ruleName): string|array
	{
		return $this->translator->get($this->getKey($ruleName));
	}

	private function getKey(string $ruleName): string
	{
		return "validation_codes::codes.{$ruleName}";
	}
}