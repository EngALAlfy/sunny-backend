<?php
/*
 * Project: sunny-backend
 * File: UpdateDoctorRequest.php
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

class UpdateDoctorRequest extends FormRequest
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
            'photo' => 'nullable|max:800|image',
            'address' => 'nullable|string|max:200',
            'phone' => 'nullable|max:13|unique:doctors,phone,'.$this->doctor->id.',id',
            'desc' => 'nullable|max:500',
            'email' => 'required|unique:doctors,email,'.$this->doctor->id.',id|email',
            'open_at' => 'nullable',
            'close_at' => 'nullable',
        ];
    }
}
