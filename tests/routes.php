<?php

use Illuminate\Support\Facades\Route;

Route::post('/test', function (\Illuminate\Http\Request $request) {
	$request->validate(["field_1" => "required"]);
});