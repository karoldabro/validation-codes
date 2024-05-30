<?php

namespace Kdabrow\ValidationCodes\Tests;

use Kdabrow\ValidationCodes\Factory;

class FactoryTest extends TestCase
{
	/** @test */
	public function app_resolved_instance_of_the_own_factory()
	{
	    $this->assertInstanceOf(
			Factory::class,
			app('validator'),
		);
	}
}