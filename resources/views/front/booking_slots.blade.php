@if ($bookingTime->status == 'enabled')
    @if ($bookingTime->multiple_booking === 'yes' && $bookingTime->max_booking != 0 && $bookings->count() >= $bookingTime->max_booking)
        <option>
            @lang('front.maxBookingLimitReached')
        </option>
    @else
                @php
                    $slot_count = 1;
                    $check_remaining_booking_slots = 0;
                @endphp
                @for ($d = $startTime; $d < $endTime; $d->addMinutes($bookingTime->slot_duration))
                    @php $slotAvailable = 1; @endphp
                    @if ($bookingTime->multiple_booking === 'no' && $bookings->count() > 0)
                        @foreach ($bookings as $booking)
                            @if ($booking->date_time->format($settings->time_format) == $d->format($settings->time_format))
                                @php $slotAvailable = 0; @endphp
                            @endif
                        @endforeach
                    @endif

                    @if ($slotAvailable == 1)
                        @php $check_remaining_booking_slots++; @endphp
                        <option value="{{ $d->format('H:i:s') }}">{{ $d->format($settings->time_format) }}</option>
                    @endif
                    @php $slot_count++; @endphp
                @endfor
                @if ($slot_count == 1 || $check_remaining_booking_slots == 0)
                    <option value="0">
                        @lang('front.bookingSlotNotAvailable')
                    </option>
                @endif
    @endif
@endif
