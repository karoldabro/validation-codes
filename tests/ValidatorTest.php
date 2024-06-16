<?php

namespace Kdabrow\ValidationCodes\Tests;

use Kdabrow\ValidationCodes\Validator;
use PHPUnit\Framework\Attributes\Test;

class ValidatorTest extends TestCase
{
	#[Test]
	public function app_resolved_instance_of_the_own_validator()
	{
	    $this->assertInstanceOf(
			Validator::class,
			app('validator')->make([], []),
		);

		$this->assertInstanceOf(
			Validator::class,
			validator()->make([], []),
		);
	}
}