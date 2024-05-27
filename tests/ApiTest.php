<?php

namespace Kdabrow\ValidationCodes\Tests;

use Illuminate\Testing\Fluent\AssertableJson;

class ApiTest extends TestCase
{
	/** @test */
	public function response_returns_status_422_validation_error()
	{
	    $response = $this->json('POST', '/test');

		$response->assertStatus(422);
	}

	/** @test */
	public function error_response_contains_validation_errors_key()
	{
		$response = $this->json('POST', '/test');

		$response->assertJson([
			"errors" => [
				"field_1" => [
					"The field 1 field is required.",
				],
			],
		]);
	}

	/** @test */
	public function error_response_contains_validation_codes_key()
	{
		$response = $this->json('POST', '/test');

		$response->assertJson(function(AssertableJson $json) {
			$json->has('codes')->etc();
		});
	}

	/** @test */
	public function error_response_codes_array_contains_field_with_validation_error_code()
	{
		$response = $this->json('POST', '/test');

		$response->assertJson([
			"codes" => [
				"field_1" => [
					"E104",
				],
			],
		]);
	}

	/** @test */
	public function response_contains_only_codes_while_configuration_show_only_codes_is_true()
	{
		config()->set('validation_codes.show_only_codes', true);

		$response = $this->json('POST', '/test');

		$response->assertExactJson([
			"codes" => [
				"field_1" => [
					"E104",
				],
			],
		]);
	}

	/** @test */
	public function response_contains_multiple_codes()
	{
		$response = $this->json('POST', '/test_with_multiple_errors', ["field_1" => "test"]);

		$response->assertJson([
			"codes" => [
				"field_1" => [
					"E53", "E77",
				],
			],
		]);
	}

	/** @test */
	public function response_contains_multiple_fields()
	{
		$response = $this->json('POST', '/test_with_multiple_fields', ["field_1" => "test"]);

		$response->assertJson([
			"codes" => [
				"field_1" => [
					"E53", "E77",
				],
				"field_2" => [
					"E104",
				],
			],
		]);
	}

	/** @test */
	public function response_contains_array_fields()
	{
		$response = $this->json('POST', '/test_with_array_fields', ["field_1" => [[]]]);

		$response->assertJson([
			"codes" => [
				"field_1" => [
					"E75",
				],
				"field_1.0.field_2" => [
					"E104",
				],
			],
		]);
	}

	/** @test */
	public function response_contains_errors_from_custom_validation_rules()
	{
		$response = $this->json('POST', '/test_with_custom_validation_rules', ["field_1" => 1]);

		$response->assertJson([
			"codes" => [
				"field_1" => [
					"E10000",
				],
			],
		]);
	}

	/** @test */
	public function response_contains_fallback_error_when_custom_rules_do_not_contain_the_code()
	{
		$response = $this->json('POST', '/test_with_custom_validation_rules_without_code', ["field_1" => 1]);

		$response->assertJson([
			"codes" => [
				"field_1" => [
					"E0",
				],
			],
		]);
	}
}