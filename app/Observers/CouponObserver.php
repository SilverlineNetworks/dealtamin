<?php

namespace App\Observers;

use App\Coupon;

class CouponObserver
{
    public function saving(Coupon $coupon)
    {
        if (company()) {
            $coupon->company_id = company()->id;
        }
        $coupon->title = strtolower($coupon->title);
        $coupon->code = strtolower($coupon->code);
        $coupon->days = json_encode($coupon->days);
    }
}
