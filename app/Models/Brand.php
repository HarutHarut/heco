<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    use HasFactory;

    protected $fillable = [
        'name'
    ];

    public function models()
    {
        return $this->hasMany(BrandModel::class);
    }

    public function bikes()
    {
        return $this->hasMany(Bike::class);
    }
}
