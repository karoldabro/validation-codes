<?php

namespace Kdabrow\ValidationCodes\Tests\Helpers;

class ExtendingRuleWithCode
{
	public function validate($attribute, $value, $parameters, $validator)
	{
		return false;
	}
}