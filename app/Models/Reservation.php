<?php
/*
 * Project: sunny-backend
 * File: Reservation.php
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
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    use HasFactory;
    use HasCreatedByTrait;

    protected $fillable = [
        'name',
        'phone',
        'email',
        'address',
        'note',
        'date',
        'status',
        'service_id',
        'doctor_id',
    ];

    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }
}
