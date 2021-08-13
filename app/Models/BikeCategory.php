<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BikeCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'bike_id',
        'category_id'
    ];



}
