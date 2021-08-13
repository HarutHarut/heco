<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class Page extends Model
{
    use HasFactory;

    protected $fillable = [
        'slug'
    ];

    const PAGES = [
        'Privacy Policy' => 'Privacy Policy',
        'Terms' => 'Terms',
        'Impressum ' => 'Impressum'
    ];

    public function data()
    {
        return $this->hasOne(PageData::class)->where('lang', LaravelLocalization::getCurrentLocale());
    }

    public function allData()
    {
        return $this->hasMany(PageData::class);
    }
}
