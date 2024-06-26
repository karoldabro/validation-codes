<?php

use Illuminate\Support\Facades\Route;

Route::post('/test', function (\Illuminate\Http\Request $request) {
	$request->validate(["field_1" => "required"]);
});

Route::post('/test_with_multiple_errors', function (\Illuminate\Http\Request $request) {
	$request->validate(["field_1" => "integer|min:100"]);
});

Route::post('/test_with_multiple_fields', function (\Illuminate\Http\Request $request) {
	$request->validate(["field_1" => "integer|min:100", "field_2" => "required"]);
});

Route::post('/test_with_array_fields', function (\Illuminate\Http\Request $request) {
	$request->validate(["field_1" => "required|array|min:100", "field_1.*.field_2" => "required|int"]);
});

Route::post('/test_with_custom_validation_rules', function (\Illuminate\Http\Request $request) {
	$request->validate(["field_1" => [new \Kdabrow\ValidationCodes\Tests\Helpers\CustomRule()]]);
});

Route::post('/test_with_custom_validation_rules_without_code', function (\Illuminate\Http\Request $request) {
	$request->validate(["field_1" => [new \Kdabrow\ValidationCodes\Tests\Helpers\CustomRuleWithoutCode()]]);
});

Route::post('/test_with_not_existing_validation_code', function (\Illuminate\Http\Request $request) {
	$request->validate(["field_1" => ['rule_without_code']]);
});

Route::post('/test_with_existing_validation_code', function (\Illuminate\Http\Request $request) {
	$request->validate(["field_1" => ['rule_with_code']]);
});