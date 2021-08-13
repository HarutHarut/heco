<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

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
        return [
            'last_name' => 'required|string|max:255',
            'first_name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $this->route('user'),
            'phone' => 'required',
            'country' => 'string|nullable|max:255',
            'city' => 'string|nullable|max:255',
            'street' => 'string|nullable|max:255',
            'house_number' => 'string|nullable|max:255',
            'zip' => 'string|nullable|max:255'
        ];
    }
}
