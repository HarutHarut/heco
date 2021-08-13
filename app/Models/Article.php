<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class Article extends Model
{
    use HasFactory;

    protected $fillable = [
        'slug',
        'image',
        'status',
        'count_of_visits'
    ];

    public function data()
    {
        return $this->hasOne(ArticleData::class)->where('lang', LaravelLocalization::getCurrentLocale());
    }

    public function allData()
    {
        return $this->hasMany(ArticleData::class);
    }

    public function imageThumb($type = null)
    {
        $path = $type ? '/thumb/' . $type : $type;
        return '/storage/articles/' . $this->id . $path . '/' . $this->getRawOriginal('image');
    }
}
