<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

class BikeRequest extends FormRequest
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
            'price' => 'required|numeric|gt:0',
            'frame_size' => 'required|string',
            'condition' => 'required',
            'milage' => 'required',
            'last_service' => 'required',
            'preowned' => 'required',
            'shipping' => 'required',
            'location' => 'required',
        ];
    }
}
