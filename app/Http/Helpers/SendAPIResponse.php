<?php

namespace App\Http\Helpers;

use Illuminate\Http\JsonResponse;

trait SendAPIResponse
{

    function success($data, $message, $code = 200): JsonResponse
    {
        return response()->json(["success" => true, "data" => $data, "message" => $message], $code);
    }

    function error($message, $code = 422): JsonResponse
    {
        return response()->json(["success" => false, "message" => $message, "data" => null], $code);
    }
}
