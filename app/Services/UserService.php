<?php
/*
 * Project: sunny-backend
 * File: UserService.php
 * Author: Islam alalfy
 * Company: alalfy.com
 * Website: https://alalfy.com
 * GitHub: https://github.com/EngALAlfy/sunny-backend
 *
 * Copyright (c) 2023 Islam alalfy. All rights reserved.
 * This code is private and confidential.
 * Unauthorized copying or distribution of this file is strictly prohibited.
 */

namespace App\Services;

use App\Models\User;

class UserService
{
    /**
     * @param User|null $user
     * @return string
     */
    public static function generateUserToken(User $user = null): string
    {
        if ($user == null) {
            $user = auth()->user();
        }

        return $user->createToken("api_token")->plainTextToken;
    }
}


