<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use App\Models\ErrorLog;
use Illuminate\Support\Facades\Auth;


class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;


    public function sendResponse($status, $message, $data = [], $code)
    {
        $response = [
            'status_code' => $code,
            'success'  => $status,
            'message' => $message,
            'data'    => $data
        ];
        return response()->json($response, $code);
    }

    public function sendErrorResponse($status, $error, $data = [], $code)
    {
        $response = [
            'status_code' => $code,
            'success'  => $status,
            'message' => $error,
            'data'    => $data
        ];
        return response()->json($response, $code);
    }

    public function handleException($e)
    {
        $exception_message = $e->getMessage() . " in " . $e->getFile() . " on line no " . $e->getLine();

        return response()->json([
            "status" => false,
            "message" => $exception_message
        ], 500);
    }
}
