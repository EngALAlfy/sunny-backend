<?php
/*
 * Project: sunny-backend
 * File: StorePaymentTransactionRequest.php
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

class StorePaymentTransactionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->user()->isAdmin();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'user_id' => "nullable|exists:users,id",
            'payable_id' => "nullable",
            'value' => "required|numeric",
            'type' => "required",
            'note' => "nullable",
            'client_name' => "nullable|max:200",
            'client_email' => "nullable|max:100|email",
            'client_phone' => "nullable|max:13",
        ];
    }
}
