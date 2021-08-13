<?php

namespace App\Models;

use App\Services\ImagesService;
use BaconQrCode\Renderer\Image\ImagickImageBackEnd;
use BaconQrCode\Renderer\ImageRenderer;
use BaconQrCode\Renderer\RendererStyle\RendererStyle;
use BaconQrCode\Writer;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Spatie\Translatable\HasTranslations;
use Kyslik\ColumnSortable\Sortable;


class Bike extends Model
{
    use HasFactory, Sortable;

    public $casts = ['description' => 'array'];
    protected $appends = ['side_image', 'is_favorite', 'check_time', 'is_new', 'format_price'];
//    public function getTranslation(string $attributeName, string $locale, bool $useFallbackLocale = true) : string;
//    colors
    const STATUS_DETAIL_NORMAL = 0;        //GRUA
    const STATUS_DETAIL_THE_SAME = 1;      //GRUN
    const STATUS_DETAIL_CHANGED = 2;       //GELB
    const STATUS_DETAIL_BROKEN_PARTS = 3;  //RED

//    requests
    const SEND_REQUEST = 0;
    const REQUEST_APPROVED = 1;
    const REQUEST_REJECTED = -1;

//    notifi
    const REQUEST_TRUE = 1;
    const REQUEST_FALSE = 0;

    protected $fillable = [
        'name',
        'lang_message',
        'availability',
        'slug',
        'description',
        'city',
        'year',
        'weight',
        'wheels_size',
        'frame_size',
        'milage',
        'last_service',
        'color',
        'msrp',
        'msrp_currency',
        'price',
        'bargain',
        'recommended_price',
        'user_id',
        'status',
        'send_request',
        'component_id',
        'request',
        'preowned',
        'shipping',
        'token',
        'mail',
        'brand_id',
        'country_id',
        'condition',
        'brand_model_id',
        'image_path',
        'parent_id',
        'count_of_visits',
        'qr',
        'bike_id',
        'is_sold',
        'info',
        'stage',
    ];

    public $sortable = [
        'id',
        'is_sold',
        'name',
        'year',
        'msrp',
        'price',
        'status',
        'created_at'
    ];

    public $translatable = ['description'];

    protected $dates = [
        'availability'
    ];

    /**
     * @var string[]
     */
    public $sortableAs = ['views_count'];

    /**
     * @return MorphToMany
     */
    public function comments()
    {
        return $this->morphedByMany(Comment::class, 'commentable');
    }

    /**
     * @return bool
     */
    public function getIsNewAttribute()
    {
        return $this->created_at > Carbon::now()->subDays(3);
    }
    /**
     * @return false|mixed|null
     */
    public function getIsFavoriteAttribute()
    {
        if (Auth::check()) {
            return $this->favorites()->where('user_id', Auth()->id())->first();
        }
        return false;
    }

    public function getCheckTimeAttribute()
    {
        if ($this->availability && !$this->availability->isPast()) {
            return $this->availability->format('d.m.Y');
        }
        return false;
    }

    /**
     * @return BelongsToMany
     */
    public function details(): BelongsToMany
    {
        return $this->belongsToMany(Detail::class, 'bike_settings');
    }

    /**
     * @return HasMany
     */
    public function bike_settings(): HasMany
    {
        return $this->hasMany(BikeSetting::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function parent()
    {
        return $this->belongsTo(Bike::class, 'bike_id');
    }

    /**
     * @return BelongsToMany
     */
    public function category()
    {
        return $this->belongsToMany(Category::class, 'bike_categories');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne\
     */
    public function booking()
    {
        return $this->hasOne(Booking::class)->latest();
    }

    /**
     * @return BelongsToMany
     */
    public function favorites()
    {
        return $this->belongsToMany(User::class, 'favorites');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function brand()
    {
        return $this->hasOne(Brand::class, 'id', 'brand_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\hasMany
     */
    public function views()
    {
        return $this->hasMany(ViewedBicycle::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function model()
    {
        return $this->hasOne(BrandModel::class, 'id', 'brand_model_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function component()
    {
        return $this->hasOne(Component::class, 'id', 'component_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function images()
    {
        return $this->morphMany(Image::class, 'imageable');
    }

    /**
     * @param $type
     * @return string|null
     */
    public function image($type)
    {
        $image = $this->images()->where('type', $type)->first();

        return $image ? '/storage/bikes/' . $this->id . '/thumb/400/' . $image->path : null;
    }

    /**
     * @param $type
     * @return string|null
     */
    public function thumb($type)
    {
        $image = $this->images()->where('type', $type)->first();

        return $image ? '/storage/bikes/' . $this->id . '/thumb/210/' . $image->path : null;
    }

    /**
     * @return string|null
     */
    public function getSideImageAttribute()
    {
        return $this->image('side');
    }

    /**
     * @param $type
     * @return array|null
     */
    public function defectImage($type)
    {
        $data = [];
        $images = Image::where('type', $type)->where('imageable_id', $this->id)->get();
        if ($images) {
            foreach ($images as $image) {
                $data[] = 'bikes/' . $this->id . '/thumb/400/' . $image->path;
            }
            return $data;
        } else {
            return null;
        }
    }

    /**
     * @param $type
     * @return array|null
     */
    public function defectThumb($type)
    {
        $data = [];
        $images = Image::where('type', $type)->where('imageable_id', $this->id)->get();
        if ($images) {
            foreach ($images as $image) {
                $data[] = 'bikes/' . $this->id . '/thumb/210/' . $image->path;
            }
            return $data;
        } else {
            return null;
        }
    }

    /**
     * @param $image
     * @param $type
     */
    public function saveImage($image, $type)
    {
        $image_path = ImagesService::savePhoto($image, 'bikes/' . $this->id);
        $data = [
            'type' => $type,
            'imageable_id' => $this->id,
            'imageable_type' => self::class,
            'path' => $image_path];
        switch ($type) {
            case 'defects':
                Image::create($data);
                break;
            default:
                Image::updateOrCreate(['type' => $type, 'imageable_id' => $this->id, 'imageable_type' => self::class], $data);
                break;
        }
    }

    /**
     * @return string|null
     */
    public function getFormatPriceAttribute()
    {
        return $this->getRawOriginal('price') ? (app()->getLocale()=='de') ? number_format($this->price, 2,',','.') : number_format($this->price, 2,'.',','): null;
    }

    /**
     * @param $value
     * @return string
     */
    public function getQrAttribute($value)
    {
        if ($value) {
            return '/storage/' . $value;
        }
        return $value;
    }

    /**
     * Add Qr code for mobile image uploads
     */
    public function addQR()
    {
        if (config('app.env') == 'production' || config('app.env') == 'dev') {
            $renderer = new ImageRenderer(
                new RendererStyle(150),
                new ImagickImageBackEnd()
            );
            $writer = new Writer($renderer);
            $qr_name = rand('1000000', '9999999') . time() . '.png';
            $content = $writer->writeString(route('mobile.images', $this->token));
            $storage = Storage::disk('public');
            $storage->put('/wallets/' . $qr_name, $content, 'public');
            $this->qr = 'wallets/' . $qr_name;
            $this->save();
        }
    }
}
