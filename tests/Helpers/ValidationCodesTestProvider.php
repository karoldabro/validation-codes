<?php

namespace Kdabrow\ValidationCodes\Tests\Helpers;

use Illuminate\Contracts\Debug\ExceptionHandler;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;
use Kdabrow\ValidationCodes\Handler;

class ValidationCodesTestProvider extends ServiceProvider
{
	public function register()
	{
		$this->app->singleton(ExceptionHandler::class, Handler::class);
	}

	public function boot(): void
	{
		$this->loadRoutesFrom(__DIR__.'/routes.php');

		Validator::extend('rule_without_code', ExtendingRuleWithoutCode::class);
		Validator::extend('rule_with_code', ExtendingRuleWithCode::class, null, 'E10001');
	}
}