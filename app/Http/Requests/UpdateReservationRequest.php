<?php
/*
 * Project: sunny-backend
 * File: UpdateReservationRequest.php
 * Author: Islam alalfy
 * Company: alalfy.com
 * Website: https://alalfy.com
 * GitHub: https://github.com/EngALAlfy/sunny-backend
 *
 * Copyright (c) 2023 Islam alalfy. All rights reserved.
 * This code is private and confidential.
 * Unauthorized copying or distribution of this file is strictly prohibited.
 */

namespace App\Http\Requests;

use App\Http\Helpers\Constants;
use Illuminate\Foundation\Http\FormRequest;

class UpdateReservationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->user()->isClinicAdmin();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => "nullable|max:200",
            'phone' => "nullable|max:13",
            'email' => "nullable|email",
            'address' => "nullable|max:200",
            'note' => "nullable|max:300",
            'date' => "nullable",
            'status' => "nullable|in:" . Constants::RESERVATION_CANCELLED . "," . Constants::RESERVATION_WAITING . "," . Constants::RESERVATION_CONFIRMED,
        ];
    }
}
