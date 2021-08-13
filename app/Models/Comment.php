<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = [
        'body',
        'commentable_type',
        'from_id',
        'parent_id',
        'commentable_id'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function commentable()
    {
        return $this->morphTo(Bike::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function user()
    {
        return $this->hasOne(User::class, 'id', 'from_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function parent()
    {
        return $this->hasOne(Comment::class,'id','parent_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphOne
     */
    public function bike()
    {
        return $this->morphOne(Bike::class,'commentable');
    }

//    /**
//     * @return MorphToMany
//     */
//    public function userComment()
//    {
//        return $this->morphedByMany(UserComents::class, 'commentable');
//    }
}
