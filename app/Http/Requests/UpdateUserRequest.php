<?php

namespace App\Http\Requests;

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
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => ['string', 'min:4', 'max:100'],
            'email' => ['unique:users,email', 'email:rfc,dns'],
            'password' => ['string', 'min:8', 'max:32'],
            'verified' => ['boolean'],
        ];
    }
}
