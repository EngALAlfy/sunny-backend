<?php
/*
 * Project: sunny-backend
 * File: Doctor.php
 * Author: Islam alalfy
 * Company: alalfy.com
 * Website: https://alalfy.com
 * GitHub: https://github.com/EngALAlfy/sunny-backend
 *
 * Copyright (c) 2023 Islam alalfy. All rights reserved.
 * This code is private and confidential.
 * Unauthorized copying or distribution of this file is strictly prohibited.
 */

namespace App\Models;

use App\Traits\HasCreatedByTrait;
use App\Traits\HasImageTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Doctor extends Model
{
    use HasFactory;
    use HasCreatedByTrait;
    use HasImageTrait;

    protected $appends = [
        'photoName',
        'photoUrl',
        'photoHtml',
    ];
    protected $fillable = [
        'name',
        'photo',
        'address',
        'phone',
        'desc',
        'email',
        'open_at',
        'close_at',
    ];
}
