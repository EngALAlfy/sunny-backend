<?php
/*
 * Project: sunny-backend
 * File: SendAPIResponse.php
 * Author: Islam alalfy
 * Company: alalfy.com
 * Website: https://alalfy.com
 * GitHub: https://github.com/EngALAlfy/sunny-backend
 *
 * Copyright (c) 2023 Islam alalfy. All rights reserved.
 * This code is private and confidential.
 * Unauthorized copying or distribution of this file is strictly prohibited.
 */

namespace App\Http\Helpers;

use Illuminate\Http\JsonResponse;

trait SendAPIResponse
{
    function success($data, $message = "done successfully", $code = 200): JsonResponse
    {
        return response()->json(["success" => true, "data" => $data, "message" => $message], $code);
    }

    function error($message, $code = 422): JsonResponse
    {
        return response()->json(["success" => false, "message" => $message, "data" => null], $code);
    }
}
