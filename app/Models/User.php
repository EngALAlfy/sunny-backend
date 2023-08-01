<?php
/*
 * Project: sunny-backend
 * File: User.php
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

use App\Http\Helpers\Constants;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'photo',
        'role',
        'username',
        'password',
        'phone',
        'active',
    ];
    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];
    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'active' => 'boolean',
    ];

    public function scopeAdmins(Builder $query): Builder
    {
        return $query->whereIn("role" , Constants::ADMIN_ROLES);
    }

    public function scopeMembers(Builder $query): Builder
    {
        return $query->where("role" , Constants::ROLE_MEMBER);
    }

    /**
     *  Check if the user is any ype of admin
     * @return bool
     */
    public function isAdmin(): bool
    {
        return $this->isSuperAdmin() || $this->isGymAdmin() || $this->isClinicAdmin();
    }

    public function isSuperAdmin(): bool
    {
        return $this->role == Constants::ROLE_SUPER_ADMIN;
    }

    public function isGymAdmin(): bool
    {
        return $this->role == Constants::ROLE_GYM_ADMIN || $this->isSuperAdmin();
    }

    public function isClinicAdmin(): bool
    {
        return $this->role == Constants::ROLE_CLINIC_ADMIN || $this->isSuperAdmin();
    }

    public function payments(): BelongsTo
    {
        return $this->belongsTo(PaymentTransaction::class);
    }

    public function paymentsCreatedBy(): BelongsTo
    {
        return $this->belongsTo(PaymentTransaction::class, "id", "created_by_user_id");
    }

    public function subscriptions(): BelongsToMany
    {
        return $this->belongsToMany(Subscription::class);
    }

    public function benefits(): BelongsToMany
    {
        return $this->belongsToMany(Benefit::class);
    }
}
