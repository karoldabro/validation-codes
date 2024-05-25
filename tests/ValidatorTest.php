<?php

namespace Kdabrow\ValidationCodes\Tests;

use Kdabrow\ValidationCodes\Validator;

class ValidatorTest extends TestCase
{
	/** @test */
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