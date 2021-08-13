<?php

namespace App\Http\Requests\Dashboard;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\App;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class PageRequest extends FormRequest
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
        App::setLocale(LaravelLocalization::getCurrentLocale());
        return [
            'slug' => 'required|unique:pages,slug,'.request()->page,
            'title.*' => 'required',
            'description.*' => 'required',
            'short_description.*' => 'required',
        ];
    }
}
