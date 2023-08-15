<?php
/*
 * Project: sunny-backend
 * File: Service.php
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

class Service extends Model
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
        'summary',
        'photo',
        'price',
        'desc',
        'doctor_id',
    ];

    public function images(): BelongsToMany
    {
        return $this->belongsToMany(ServiceImage::class);
    }
    public function comments(): HasMany
    {
        return $this->hasMany(ServiceComment::class);
    }
}
