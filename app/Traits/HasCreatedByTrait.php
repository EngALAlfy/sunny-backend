<?php
/*
 * Project: sunny-backend
 * File: HasCreatedByTrait.php
 * Author: Islam alalfy
 * Company: alalfy.com
 * Website: https://alalfy.com
 * GitHub: https://github.com/EngALAlfy/sunny-backend
 *
 * Copyright (c) 2023 Islam alalfy. All rights reserved.
 * This code is private and confidential.
 * Unauthorized copying or distribution of this file is strictly prohibited.
 */

namespace App\Traits;

use App\Models\User;
use Illuminate\Support\Facades\Auth;

/**
 * Class HasCreatedByTrait
 * @package App\Traits
 * @property mixed $status
 */
trait HasCreatedByTrait
{

    /**
     * this is boot method
     * it is like boot() in the model
     * it fires when boot() in model fires
     * @return void
     */
    public static function bootHasCreatedByTrait(): void
    {
        static::creating(function ($model) {
            // if auth user - else system
            if (Auth::check()) {
                $model->created_by_user_id = Auth::id();
            }
        });
    }

    /**
     * this method fired when trait initialize
     * @return void
     */
    public function initializeHasActiveStatus(): void
    {
        /// add field `status` to model fillable
        $this->fillable[] = 'created_by_user_id';
    }

    public function createdByUser()
    {
        return $this->belongsTo(User::class, 'created_by_user_id', 'id');
    }
}

