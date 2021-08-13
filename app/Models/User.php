<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
use Kyslik\ColumnSortable\Sortable;

class User extends Authenticatable  implements MustVerifyEmail
{
    use HasFactory, Notifiable, Sortable;

    const ROLE_USER = 'user';
    const ROLE_ADMIN = 'admin';


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'birth_date',
        'lang_message',
        'email',
        'status',
        'role',
        'phone',
        'password',
        'provider',
        'provider_id',
        'country',
        'city',
        'street',
        'house_number',
        'email_verified_at',
        'zip',
        'state',
        'image_path',
        'account_id',
        'stage',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $appends = [
        'name'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * @var string[]
     */
    public $sortable = [
        'id',
        'last_name',
        'first_name',
        'email',
        'status',
        'created_at',
    ];

    /**
     * @var string[]
     */
    protected $dates = ['birth_date', 'email_verified_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function bikes()
    {
        return $this->hasMany(Favorite::class, 'user_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function sell_bikes()
    {
        return $this->hasMany(Bike::class, 'user_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function favorite()
    {
        return $this->belongsToMany(Bike::class, 'favorites');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function account()
    {
        return $this->belongsTo(Account::class);
    }

    /**
     * @param $role
     * @return bool
     */
    public function userRoles($role)
    {
        if (Auth::user()->role == 'admin') return true;
        return false;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    /**
     * @return HasOne
     */
    public function filter(): HasOne
    {
        return $this->hasOne(Filter::class);
    }

    /**
     * @return string
     */
    public function getImagePathAttribute()
    {
        return $this->getRawOriginal('image_path') ? '/storage/user_image/' . $this->id . '/' . $this->getRawOriginal('image_path') : '/img/profile-user.svg';
    }

    /**
     * @return string
     */
    public function getNameAttribute()
    {
        return $this->first_name . ' ' . $this->last_name;
    }

}
