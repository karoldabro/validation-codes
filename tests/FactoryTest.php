<?php

namespace Kdabrow\ValidationCodes\Tests;

use Kdabrow\ValidationCodes\Factory;
use PHPUnit\Framework\Attributes\Test;

class FactoryTest extends TestCase
{
	#[Test]
	public function app_resolved_instance_of_the_own_factory()
	{
	    $this->assertInstanceOf(
			Factory::class,
			app('validator'),
		);
	}
}