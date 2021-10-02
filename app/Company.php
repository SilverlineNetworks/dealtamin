<?php

namespace App;

use App\Observers\CompanyObserver;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Crypt;
use Laravel\Cashier\Billable;

class Company extends Model
{
    use Notifiable, Billable;

    protected $fillable = [
        'company_name',
        'company_email',
        'company_phone',
        'address',
        'date_format',
        'time_format',
        'website',
        'timezone',
        'currency_id',
        'locale',
        'logo'
    ];

    protected $appends = [
        'logo_url',
        'formatted_phone_number',
        'formatted_address',
        'formatted_website',
        'company_verification_url'
    ];

    protected static function boot()
    {
        parent::boot();

        static::observe(CompanyObserver::class);

        $company = company();

        static::addGlobalScope('company', function (Builder $builder) use ($company) {
            if ($company) {
                $builder->where('id', $company->id);
            }
        });
    }

    public function currency()
    {
        return $this->belongsTo(Currency::class);
    }

    public function package()
    {
        return $this->belongsTo(Package::class);
    }

    public function deals()
    {
        return $this->belongsToMany(Deal::class);
    }

    public function spotlight()
    {
        return $this->hasMany(Spotlight::class, 'company_id', 'id');
    }

    public function module_setting()
    {
        return $this->hasMany(ModuleSetting::class, 'company_id', 'id');
    }

    public function user()
    {
        return $this->hasMany(User::class, 'company_id', 'id');
    }

    public function gateway_account_details()
    {
        return $this->hasMany(GatewayAccountDetail::class);
    }

    public function getCompanyVerificationUrlAttribute()
    {
        return Crypt::encryptString($this->company_email);
    }

    public function getLogoUrlAttribute()
    {
        $globalSetting = GlobalSetting::first();

        if (is_null($this->logo)) {
            return '../user-uploads/logo/no.jpg';
            //return $globalSetting->logo_url;
        }
        return asset_url('company-logo/' . $this->logo);
    }

    public function getFormattedPhoneNumberAttribute()
    {
        return $this->phone_number_format($this->company_phone);
    }

    public function getFormattedAddressAttribute()
    {
        return nl2br(str_replace('\\r\\n', "\r\n", $this->address));
    }

    public function getFormattedWebsiteAttribute()
    {
        return preg_replace('/^https?:\/\//', '', $this->website);
    }

    public function phone_number_format($number)
    {
        // Allow only Digits, remove all other characters.
        $number = preg_replace("/[^\d]/", "", $number);

        // get number length.
        $length = strlen($number);

        if ($length == 10) {
            if (preg_match('/^1?(\d{3})(\d{3})(\d{4})$/', $number,  $matches)) {
                $result = $matches[1] . '-' . $matches[2] . '-' . $matches[3];
                return $result;
            }
        }

        return $number;
    }
}
