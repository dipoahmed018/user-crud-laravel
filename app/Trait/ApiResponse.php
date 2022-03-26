<?php

namespace App\Trait;

/**
 * Handle Api Responses
 */
trait ApiResponse
{
    public function failed($error = "Something went wrong!", $code = 500, $status = 'failed')
    {
        $response = ['error' => $error, 'status' => $status];
        return response()->json($response, $code);
    }

    public function success($data = [], $code = 200, $status = 'success')
    {
        $response = ['data' => $data, 'status' => $status];
        return response()->json($response, $code);
    }
}
