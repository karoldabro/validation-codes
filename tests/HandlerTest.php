<?php

namespace Kdabrow\ValidationCodes\Tests;

use Illuminate\Contracts\Debug\ExceptionHandler;
use Kdabrow\ValidationCodes\Handler;
use PHPUnit\Framework\Attributes\Test;

class HandlerTest extends TestCase
{
	#[Test]
	public function app_resolves_instance_of_our_handler()
	{
		$this->assertInstanceOf(
			Handler::class,
			app(ExceptionHandler::class),
		);
	}
}