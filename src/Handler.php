<?php

namespace Kdabrow\ValidationCodes;

use Illuminate\Validation\ValidationException;

class Handler extends \Illuminate\Foundation\Exceptions\Handler
{
	/**
	 * Convert a validation exception into a JSON response.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Illuminate\Validation\ValidationException  $exception
	 * @return \Illuminate\Http\JsonResponse
	 */
	protected function invalidJson($request, ValidationException $exception)
	{
		if (config('validation_codes.show_only_codes')) {
			return response()->json([
				'codes' => $exception->validator->getCodes()->messages(),
			], $exception->status);
		}

		return response()->json([
			'message' => $exception->getMessage(),
			'errors' => $exception->errors(),
			'codes' => $exception->validator->getCodes()->messages(),
		], $exception->status);
	}
}