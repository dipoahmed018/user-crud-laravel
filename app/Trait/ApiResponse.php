<?php

namespace App\Trait;

/**
 * Handle Api Responses
 */
trait ApiResponse
{
    public function failed($message = "Something went wrong!", $code = 500, $error = [])
    {
        $response = ['errors' => $error, 'message' => $message];
        return response()->json($response, $code);
    }

    public function success($message = 'success', $code = 200, $data = [])
    {
        $response = ['data' => $data, 'message' => $message];
        return response()->json($response, $code);
    }
}
