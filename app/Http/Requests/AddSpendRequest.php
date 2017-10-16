<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Spend;
use Log;

class AddSpendRequest extends FormRequest
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
        return Spend::$rules;
    }

    public function messages()
    {
        return [
            'title.required' => 'Please enter title!',
            'date.required' => 'Please enter date!',
            'amount.required' => 'Please enter amount!'
        ];
    }
}
