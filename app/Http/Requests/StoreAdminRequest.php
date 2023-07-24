<?php

namespace App\Http\Requests;

use App\Http\Helpers\Constants;
use Illuminate\Foundation\Http\FormRequest;

class StoreAdminRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->user()->isSuperAdmin();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|max:200',
            'username' => 'required|unique:users,username|max:100|min:3',
            'email' => 'required|email|unique:users,email|max:200',
            'password' => 'required|max:200|min:4',
            'phone' => 'nullable|unique:users,phone|max:13',
            'photo' => 'nullable|image|max:800',
            'role' => "nullable|in:" . join(",", Constants::ADMIN_ROLES),
        ];
    }
}
