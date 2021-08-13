<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserComents extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'commentable_id',
        'comment_id'
    ];

    public function parent()
    {
        return $this->hasOne(Comment::class, 'parent_id');
    }

}
