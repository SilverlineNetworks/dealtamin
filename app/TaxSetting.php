<?php

namespace App;

use App\Observers\TaxSettingObserver;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class TaxSetting extends Model
{
    protected $guarded = ['id'];

    protected static function boot()
    {
        parent::boot();

        static::observe(TaxSettingObserver::class);

        static::addGlobalScope('company', function (Builder $builder) {
            if (company()) {
                $builder->where('company_id', company()->id);
            }
        });
    }

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }
}
