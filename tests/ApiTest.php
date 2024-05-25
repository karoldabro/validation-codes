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
}