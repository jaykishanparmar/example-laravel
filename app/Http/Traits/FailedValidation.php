<?php

namespace App\Http\Traits;


use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Response;

/**
 * use for failed validation
 */
trait FailedValidation
{

   protected function failedValidation(Validator $validator)
   {
      throw new HttpResponseException(response()->json([
         'success' => false,
         'status_code' => Response::HTTP_UNPROCESSABLE_ENTITY,
         'message' => "The given data was invalid",
         'error' => $validator->errors(),
      ], Response::HTTP_UNPROCESSABLE_ENTITY));
   }
}
