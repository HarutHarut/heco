<?php

namespace App\Http\Requests;

use App\Models\Bike;
use Illuminate\Foundation\Http\FormRequest;

class ImageRequest extends FormRequest
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
        $rules = [
            'defects' => 'nullable|array',
            'defects.*' => [
                'image',
                'mimes:jpeg,png,jpg',
                'max:2048'
            ]
        ];

        $bike = Bike::findOrFail($this->route('bike_id'));
        $side = $bike->images()->where('type', 'side')->first();
        if(!$side){
            $rules['side'] = 'required|mimes:jpeg,png,jpg|max:5120';
        }
        $crank = $bike->images()->where('type', 'crank')->first();
        if(!$crank){
            $rules['crank'] = 'required|mimes:jpeg,png,jpg|max:5120';
        }
        $top = $bike->images()->where('type', 'top')->first();
        if(!$top){
            $rules['top'] = 'required|mimes:jpeg,png,jpg|max:5120';
        }

        return $rules;
    }
    public function messages()
    {
        $message['defects.*.max'] = "Each image may not be greater than 5MB.";
        $message['defects.*.mimes'] ="Each image must be a file of type: jpeg, png, jpg.";
        return $message;

    }
}
