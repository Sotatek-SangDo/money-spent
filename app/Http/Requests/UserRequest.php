<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\User;

class UserRequest extends FormRequest
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
        return User::$rules;
    }

    public function messages()
    {
        return [
            'email.required' => 'Please enter email!',
            'name.required' => 'Please enter username!',
            'password.required' => 'Please enter password!'
        ];
    }
}
