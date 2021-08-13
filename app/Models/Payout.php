<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Payout extends Model
{
    use HasFactory;

    /**
     * @var string
     */
    protected $table = 'payouts';

    /**
     * @var string[]
     */
    protected $fillable = ['user_id', 'amount', 'payout_id'];

    /**
     * @return BelongsTo
     */
    public function user():BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
