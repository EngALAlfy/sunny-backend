<?php
/*
 * Project: sunny-backend
 * File: PaymentTransaction.php
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
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class PaymentTransaction extends Model
{
    use HasFactory;
    use HasCreatedByTrait;

    protected $fillable = [
        'user_id',
        'payable_id',
        'payable_type',
        'value',
        'type',
        'note',
    ];

    function payable(): MorphTo
    {
        return $this->morphTo();
    }

    function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
