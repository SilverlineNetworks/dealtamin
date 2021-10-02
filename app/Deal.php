<?php

namespace App;

use App\Observers\DealObserver;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Deal extends Model
{

    //------------------------------------ Attributes ---------------------------

    protected $guarded = ['id'];

    private $settings;

    public function __construct() {
        parent::__construct();
        $this->settings = Company::first();
    }

    protected static function boot() {
        parent::boot();
        static::observe(DealObserver::class);

        static::addGlobalScope('company', function (Builder $builder) {
            if (company()) {
                $builder->where('company_id', company()->id);
            }
        });
    }

    protected $appends = [
        'deal_image_url', 'applied_between_time', 'deal_detail_url'
    ];

    //------------------------------------ Relations ----------------------------

    public function location() {
        return $this->belongsTo(Location::class);
    }

    public function company() {
        return $this->belongsTo(Company::class);
    }

    public function services() {
        return $this->hasMany(DealItem::class);
    }

    public function bookingItems() {
        return $this->hasMany(BookingItem::class);
    }

    public function spotlight() {
        return $this->hasMany(Spotlight::class, 'deal_id', 'id');
    }

    public function bookings() {
        return $this->hasMany(Booking::class);
    }

    //------------------------------------ Scopes -------------------------------

    public function scopeActive($query) {
        return $query->where('status', 'active');
    }

    //------------------------------------ Accessors ----------------------------

    public function getDealImageUrlAttribute() {
        if(is_null($this->image)){
            return asset('img/no-image.jpg');
        }
        return asset_url('deal/'.$this->image);
    }


    public function getAppliedBetweenTimeAttribute() {
        return $this->open_time.' - '.$this->close_time;
    }

    public function getStartDateAttribute($value) {
        $date = new Carbon($value);
        return $date->format('Y-m-d h:i A');
    }

    public function getEndDateAttribute($value) {
        $date = new Carbon($value);
        return $date->format('Y-m-d h:i A');
    }

    public function getOpenTimeAttribute($value) {
        return Carbon::createFromFormat('H:i:s', $value)->setTimezone($this->settings->timezone)->format($this->settings->time_format);
    }

    public function getCloseTimeAttribute($value) {
        return Carbon::createFromFormat('H:i:s', $value)->setTimezone($this->settings->timezone)->format($this->settings->time_format);
    }

    public function getmaxOrderPerCustomerAttribute($value) {
        if($this->uses_limit==0 && $value==0) {
            return 'Infinite';
        }
        elseif($this->uses_limit>0 && ($value==0 || $value=='')) {
            return $this->uses_limit;
        }
        return $value;
    }

    public function getDealDetailUrlAttribute() {
        return route('front.dealDetail', ['dealSlug' => $this->slug]);
    }
} /* end of class */
