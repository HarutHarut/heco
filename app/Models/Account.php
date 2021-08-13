<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class Account extends Model
{
    use HasFactory, Sortable;

    /**
     * @var string
     */
    protected $table = 'accounts';

    /**
     * @var array
     */
    protected $fillable = ['account_id', 'personal_id_number', 'account_number'];


}
