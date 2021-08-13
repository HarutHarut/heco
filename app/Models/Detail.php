<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Detail extends Model
{
    use HasFactory;

    const DETAIL_STATUS = [
        0 => 'radio-grey',
        1 => 'radio-green',
        2 => 'radio-yellow',
        3 => 'radio-red'
    ];
    const DETAIL_COLOR = [
        0 => '',
        1 => 'green-td',
        2 => 'yellow-td',
        3 => 'red-td'
    ];
    protected $fillable = [
        'key',
        'is_show'
    ];

}
