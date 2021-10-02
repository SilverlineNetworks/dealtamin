<?php

namespace App\Observers;

use App\Booking;
use App\Company;
use App\Notifications\BookingStatusChange;
use Carbon\Carbon;

class BookingObserver
{
    public function creating(Booking $booking)
    {
        if (company()) {
            $booking->company_id = company()->id;
        }
    }

    public function updating(Booking $booking)
    {

    }

    public function updated(Booking $booking)
    {
        if ($booking->isDirty('status')){
            $booking->user->notify(new BookingStatusChange($booking));
        }

        $booking = Booking::with([
            'user' => function($q) { $q->withoutGlobalScope('company'); } ])
            ->find($booking->id);
    }
}
