<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class Booking extends Model
{
    use HasFactory, Sortable;

    const SHIPPING = 50;
    const FEE_PERCENT = 1.5;
    const SERVICE_FEE = 30;
    const PACKAGING = 20;

//    const SHIPPING = 0;
//    const FEE_PERCENT = 1.5;
//    const SERVICE_FEE = 1;
//    const PACKAGING = 0;

    protected $appends = [
        'format_price'
    ];

    protected $fillable = [
        'bike_id',
        'user_id',
        'price',
        'status',
        'token',
        'payment_id',
        'phone',
        'country',
        'city',
        'street',
        'house_number',
        'zip',
        'action_token',
        'seller_confirm',
        'buyer_confirm',
        'pickup_date',
        'bike_price',
        'is_shipping',
        'service_fee',
        'package_id'
    ];

    public $sortable = [
        'id',
        'price',
        'shipping',
        'updated_at',
    ];

    protected $dates = ['pickup_date'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function bike()
    {
        return $this->hasOne(Bike::class, 'id', 'bike_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    /**
     * @return string|null
     */
    public function getFormatPriceAttribute()
    {
        return $this->getRawOriginal('price') ? (app()->getLocale() == 'de') ? number_format($this->price, 2, ',', '.') : number_format($this->price, 2, '.', ',') : null;
    }

    public function getPackageNameAttribute()
    {
        return config("enums.service_fee.$this->package_id")['name'];
    }

}
