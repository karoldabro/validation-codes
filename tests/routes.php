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
	try{
	$request->validate(["field_1" => "array|min:100", "field_1.*.field_2" => "required"]);

} catch (Throwable $exception) {
	dd($exception);
}
});