<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddBenefitToSubscriptionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->user()->isGymAdmin();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            "benefit_id" => "required|exists:benefits,id",
            "limit" => "required|numeric",
        ];
    }
}
