<?php
/*
 * Project: sunny-backend
 * File: Constants.php
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

class Constants
{
    // Section Roles
    public const ROLE_SUPER_ADMIN = "super_admin";
    public const ROLE_ADMIN = "admin";
    public const ROLE_CLINIC_ADMIN = "clinic_admin";
    public const ROLE_GYM_ADMIN = "gym_admin";
    public const ROLE_MEMBER = "member";

    public const ROLES = [
        self::ROLE_MEMBER,
        self::ROLE_GYM_ADMIN,
        self::ROLE_CLINIC_ADMIN,
        self::ROLE_ADMIN,
        self::ROLE_SUPER_ADMIN
    ];
    public const ADMIN_ROLES = [
        self::ROLE_GYM_ADMIN,
        self::ROLE_CLINIC_ADMIN,
        self::ROLE_ADMIN,
        self::ROLE_SUPER_ADMIN
    ];

    // Section payment type
    public const PAYMENT_CASH = "cash";
    public const PAYMENT_ONLINE = "online";

    // Section subscriptions duration
    public const DURATION_MONTHLY = "monthly";
    public const DURATION_QUARTER = "quarter";
    public const DURATION_SEMI = "semi";
    public const DURATION_YEARLY = "yearly";

    // Section reservation status
    public const RESERVATION_CONFIRMED = "confirmed";
    public const RESERVATION_CANCELLED = "cancelled";
    public const RESERVATION_WAITING = "waiting";
}
