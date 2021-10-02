<?php

namespace App\Observers;

use App\TaxSetting;

class TaxSettingObserver
{
    public function saving(TaxSetting $setting)
    {
        if (company()) {
            $setting->company_id = company()->id;
        }
    }
}
