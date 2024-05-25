<?php

namespace Kdabrow\ValidationCodes\Tests;

use Illuminate\Support\ServiceProvider;

class ValidationCodesTestProvider extends ServiceProvider
{
	public function boot(): void
	{
		$this->loadRoutesFrom(__DIR__.'/routes.php');
	}
}