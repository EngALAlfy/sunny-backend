<?php

namespace App\Http\Requests;

use App\Http\Helpers\Constants;
use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->user()->isAdmin() || auth()->id() == $this->user->id;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'nullable|max:200',
            'username' => 'nullable|unique:users,username,'. $this->user->id .',id|max:100|min:3',
            'email' => 'nullable|email|unique:users,email,'.$this->user->id.',id|max:200',
            'password' => 'nullable|max:200|min:4',
            'phone' => 'nullable|unique:users,phone,'.$this->user->id.',id|max:13',
            'photo' => 'nullable|image|max:800',
        ];
    }
}
