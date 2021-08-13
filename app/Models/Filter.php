<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Filter extends Model
{
    use HasFactory;

    /**
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * @var string
     */
    protected $table = 'filters';

    /**
     * @var array
     */
    protected $fillable = ['user_id', 'filter'];

    /**
     * @var string[]
     */
    protected $casts = [
        'filter' =>'array'
    ];

    /**
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }


}
