<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Favorite extends Model
{
    use HasFactory;

    /**
     * @var string
     */
    protected $table = 'favorites';

    /**
     * @var string[]
     */
    protected $fillable = [
        'user_id',
        'bike_id'
    ];

    /**
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return BelongsTo
     */
    public function bike(): BelongsTo
    {
        return $this->belongsTo(Bike::class);
    }

}
