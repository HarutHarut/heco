<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class NewBikeRequest extends Model
{
    use HasFactory, Sortable;

//    requests
    const REQUEST = 0;
    const REQUEST_APPROVED = 1;
    const REQUEST_REJECTED = -1;

    protected $fillable = [
        'brand',
        'model',
        'email',
        'year',
        'status',
        'lang_message'
    ];

    public $sortable = [
        'id',
        'brand',
        'model',
        'email',
        'year',
        'created_at'
    ];

}
