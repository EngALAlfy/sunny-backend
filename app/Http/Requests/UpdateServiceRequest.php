<?php
/*
 * Project: sunny-backend
 * File: UpdateServiceRequest.php
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

use Illuminate\Foundation\Http\FormRequest;

class UpdateServiceRequest extends FormRequest
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
            'name' => 'nullable|max:200|min:3',
            'desc' => 'nullable|max:500',
            'summary' => 'nullable|max:200',
            'photo' => 'nullable|max:800|image',
            'images' => 'nullable|array',
            'doctor_id' => 'nullable|exists:doctors,id',
        ];
    }
}
