<?php
/*
 * Project: sunny-backend
 * File: Subscription.php
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
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Subscription extends Model
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
        'duration',
        'price',
        'photo',
    ];

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class);
    }

    public function benefits(): BelongsToMany
    {
        return $this->belongsToMany(Benefit::class)->withPivot(["unit_price" , "limit"]);
    }
}
