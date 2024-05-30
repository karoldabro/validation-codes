<?php

namespace Kdabrow\ValidationCodes;

use Illuminate\Support\Str;
use Illuminate\Validation\Validator;

class Factory extends \Illuminate\Validation\Factory
{
	/**
	 * All of the fallback codes for custom rules.
	 *
	 * @var array<string, string>
	 */
	protected $fallbackCodes = [];

	/**
	 * Register a custom validator extension.
	 *
	 * @param  string  $rule
	 * @param  \Closure|string  $extension
	 * @param  string|null  $message
	 * @return void
	 */
	public function extend($rule, $extension, $message = null, $code = null)
	{
		$this->extensions[$rule] = $extension;

		if ($message) {
			$this->fallbackMessages[Str::snake($rule)] = $message;
		}

		if ($code) {
			$this->fallbackCodes[Str::snake($rule)] = $code;
		}
	}

	/**
	 * Add the extensions to a validator instance.
	 *
	 * @param  \Illuminate\Validation\Validator  $validator
	 * @return void
	 */
	protected function addExtensions(Validator $validator)
	{
		$validator->addExtensions($this->extensions);

		// Next, we will add the implicit extensions, which are similar to the required
		// and accepted rule in that they're run even if the attributes aren't in an
		// array of data which is given to a validator instance via instantiation.
		$validator->addImplicitExtensions($this->implicitExtensions);

		$validator->addDependentExtensions($this->dependentExtensions);

		$validator->addReplacers($this->replacers);

		$validator->setFallbackMessages($this->fallbackMessages);

		$validator->setFallbackCodes($this->fallbackCodes);
	}
}