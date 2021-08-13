<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AdressRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
//        return $this->get('shipping_met') == 'delivery';
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $method = $this->get('shipping_met');

        if ($method == 'delivery') {
            $rules = [
                "first_name" => "required|string|max:255",
                "last_name" => "required|string|max:255",
                "phone" => "required",
                "city" => "required|string|max:255",
                "street" => "required",
                "house_number" => "required",
                "zip" => "required"
            ];
        } else {
            $rules = [
                //
            ];
        }

        return $rules;
    }
}
