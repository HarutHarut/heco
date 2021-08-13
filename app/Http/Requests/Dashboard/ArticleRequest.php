<?php

namespace App\Http\Requests\Dashboard;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\App;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class ArticleRequest extends FormRequest
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
            'title.*' => 'required',
            'description.*' => 'required',
            'short_description.*' => 'required|max:255',
            'image' => 'max:3072',
        ];
    }
}
