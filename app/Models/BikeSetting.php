<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BikeSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'detail_id',
        'bike_id',
        'value',
        'status',
        'note',
    ];

//    public function detail()
//    {
//        return $this->hasOne(Detail::class);
//    }
    public function detail()
    {
        return $this->belongsTo(Detail::class);
    }

}
