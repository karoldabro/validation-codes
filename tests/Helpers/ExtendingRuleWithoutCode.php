<?php

namespace Kdabrow\ValidationCodes\Tests\Helpers;

class ExtendingRuleWithoutCode
{
	public function validate($attribute, $value, $parameters, $validator)
	{
		return false;
	}
}