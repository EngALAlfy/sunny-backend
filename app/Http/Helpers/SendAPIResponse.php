<?php

namespace App\Http\Helpers;

use Illuminate\Http\JsonResponse;

trait SendAPIResponse
{

    function success($code = 200): JsonResponse
    {
        return response()->json(true, $code);
    }

    function error($code = 422): JsonResponse
    {
        return response()->json(false, $code);
    }
}
