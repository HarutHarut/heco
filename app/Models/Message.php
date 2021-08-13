<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;

    protected $fillable =[
        'message',
        'answer',
        'read_at',
        'sender_id',
        'recivient_id',
        'bike_id',
        'status',
    ];

    public function bike()
    {
        return $this->belongsTo(Bike::class);
    }

    public function sender()
    {
        return $this->belongsTo(User::class);
    }

    public function recivient()
    {
        return $this->belongsTo(User::class);
    }
}
