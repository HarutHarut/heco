<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ArticleData extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'article_id',
        'lang',
        'description',
        'short_description'
    ];


}
