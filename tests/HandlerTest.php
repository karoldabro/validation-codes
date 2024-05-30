<?php

namespace Kdabrow\ValidationCodes\Tests;

use Illuminate\Contracts\Debug\ExceptionHandler;
use Kdabrow\ValidationCodes\Handler;

class HandlerTest extends TestCase
{
	/** @test */
	public function app_resolves_instance_of_our_handler()
	{
		$this->assertInstanceOf(
			Handler::class,
			app(ExceptionHandler::class),
		);
	}
}