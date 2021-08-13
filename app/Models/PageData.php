<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PageData extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'page_id',
        'lang',
        'description',
        'short_description'
    ];
}