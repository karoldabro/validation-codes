<?php

namespace Kdabrow\ValidationCodes\Providers;

use Illuminate\Container\Container;
use Illuminate\Contracts\Debug\ExceptionHandler;
use Illuminate\Support\ServiceProvider;
use Kdabrow\ValidationCodes\Factory;
use Kdabrow\ValidationCodes\Handler;
use Kdabrow\ValidationCodes\Validator;

class ValidationCodesProvider extends ServiceProvider
{
	public function register()
	{
		$this->mergeConfigFrom($this->pathTo('config' . DIRECTORY_SEPARATOR . 'validation_codes.php'), 'validation_codes');

		$this->app->extend('validator', function ($translator, Container|null $container = null) {
			$factory = new Factory($translator->getTranslator(), $container);

			if (isset($this->app['db'], $this->app['validation.presence'])) {
				$factory->setPresenceVerifier($this->app['validation.presence']);
			}

			$factory->resolver(function ($translator, array $data, array $rules, array $messages, array $attributes) {
				return new Validator($translator, $data, $rules, $messages, $attributes);
			});

			return $factory;
		});

		$this->app->singleton(ExceptionHandler::class, Handler::class);
	}

	public function boot()
	{
		$this->loadTranslationsFrom($this->pathTo('lang'), 'validation_codes');

		$this->publishes([
			$this->pathTo('config/validation_codes.php') => $this->app->configPath('validation_codes.php'),
			$this->pathTo('lang') => $this->app->langPath('vendor/validation_codes'),
		], "validation_codes");
	}

	private function pathTo(string $directory): string
	{
		return __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . $directory;
	}
}