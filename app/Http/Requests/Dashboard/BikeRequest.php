<?php

namespace App\Http\Requests\Dashboard;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

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
    public function rules(Request $request)
    {
        App::setLocale(LaravelLocalization::getCurrentLocale());
        return [
            'name' => 'required|string|max:255',
            'availability' => 'nullable|after:' . date('d.m.Y'),
            'last_service' => 'nullable|string|max:255',
            'condition' => 'nullable|string|max:255',
            'milage' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:255',
            'msrp' => 'required|regex:/^\d+(\.\d{1,5})?$/|gt:0',
            'price' => 'nullable|regex:/^\d+(\.\d{1,5})?$/|gt:0',
            'weight' => 'nullable|regex:/^\d+(\.\d{1,5})?$/|gt:0',
            'frame_size' => 'nullable|regex:/^\d+(\.\d{1,2})?$/|gt:42|max:64',
            'brand_model_id' => 'required|integer',
            'brand_id' => 'required|integer',
            'top' => 'max:3072',
            'crank' => 'max:3072',
            'side' => 'max:3072',
            'defects.*' => 'max:3072',
            'description.*' => 'max:255',
            'year' => 'required|integer|min:1900|max:' . (date('Y') + 1)
        ];

    }
}
