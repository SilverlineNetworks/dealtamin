<style>
    #users-list {
        margin: 0.2em;
    }
</style>

<div class="row">
    <div class="col-md-12 text-right mt-2 mb-2">
        @if ($user->roles()->withoutGlobalScopes()->first()->hasPermission('update_booking') && $user->roles()->withoutGlobalScopes()->first()->name !== 'customer')
        <button class="btn btn-sm btn-outline-primary edit-booking" data-booking-id="{{ $booking->id }}" type="button"><i class="fa fa-edit"></i> @lang('app.edit')</button>
        @endif
        @if ($user->roles()->withoutGlobalScopes()->first()->hasPermission('delete_booking'))
        <button class="btn btn-sm btn-outline-danger delete-row" data-row-id="{{ $booking->id }}" type="button"><i class="fa fa-times"></i> @lang('app.delete') @lang('app.booking')</button>
        @endif
        @if ($booking->status == 'pending')
            @if ($user->roles()->withoutGlobalScopes()->first()->hasPermission('create_booking') && $booking->date_time!='' && $booking->date_time->greaterThanOrEqualTo(\Carbon\Carbon::now()) )
            <a href="javascript:;" data-booking-id="{{ $booking->id }}" class="btn btn-outline-dark btn-sm send-reminder"><i class="fa fa-send"></i> @lang('modules.booking.sendReminder')</a>
            @endif
            @if ($user->roles()->withoutGlobalScopes()->first()->hasPermission('update_booking'))
            <button class="btn btn-sm btn-outline-danger cancel-row" data-row-id="{{ $booking->id }}" type="button"><i class="fa fa-times"></i> @lang('modules.booking.requestCancellation')</button>
            @endif
        @endif
    </div>

    <div class="col-md-12 text-center mb-3">
        <img src="{{ $booking->user ? $booking->user->user_image_url : '' }}" class="border img-bordered-sm img-circle" height="70em" width="70em">
        <h6 class="text-uppercase mt-2">{{ ucwords($booking->user ? $booking->user->name : '') }}</h6>
    </div>

</div>

<div class="row">
    <div class="col-md-6 border-right"> <strong>@lang('app.email')</strong> <br>
        <p class="text-muted"><i class="icon-email"></i> {{ $booking->user->email ?? '--' }}</p>
    </div>
    <div class="col-md-6"> <strong>@lang('app.mobile')</strong> <br>
        <p class="text-muted"><i class="icon-mobile"></i> {{ $booking->user->mobile ? $booking->user->formatted_mobile : '--' }}</p>
    </div>
</div>
<hr>

<div class="row">
    <div class="col-sm-4 border-right"> <strong>@lang('app.booking') @lang('app.date')</strong> <br>
        <p class="text-primary"><i class="icon-calendar"></i>
            @if ($booking->date_time != '')
                {{  \Carbon\Carbon::parse($booking->date_time)->translatedFormat($settings->date_format) }}
            @endif
        </p>
    </div>
    <div class="col-sm-4 border-right"> <strong>@lang('app.booking') @lang('app.time')</strong> <br>
        <p class="text-primary"><i class="icon-alarm-clock"></i>
            @if ($booking->date_time != '')
                {{ $booking->date_time->translatedFormat($settings->time_format) }}
            @endif
        </p>
    </div>
    <div class="col-sm-4"> <strong>@lang('app.booking') @lang('app.status')</strong> <br>
        <span class="text-uppercase small border
        @if($booking->status == 'completed') border-success text-success @endif
        @if($booking->status == 'pending') border-warning text-warning @endif
        @if($booking->status == 'approved') border-info text-info @endif
        @if($booking->status == 'in progress') border-primary text-primary @endif
        @if($booking->status == 'canceled') border-danger text-danger @endif
         badge-pill">{{ __('app.'.$booking->status) }}</span>
    </div>
</div>
<hr>

@if(count($booking->users)>0)
    <div class="row">
        <div class="col-sm-12"> <strong>@lang('menu.employee') </strong> <br>
            <p class="text-primary" id="users-list">
                @foreach ($booking->users as $user)
                    &nbsp;&nbsp;&nbsp;  <i class="icon-user"></i> {{$user->name}}
                @endforeach
            </p>
        </div>
    </div>
    <hr>
@endif

<div class="row">
    <div class="col-md-12">
        <table class="table table-condensed">
            <thead class="bg-secondary">
            <tr>
                <th>#</th>
                <th>@lang('app.item')</th>
                <th>@lang('app.unitPrice')</th>
                <th>@lang('app.quantity')</th>
                <th class="text-right">@lang('app.amount')</th>
            </tr>
            </thead>
            <tbody>
            @foreach($booking->items as $key=>$item)

                @php
                    $item_name = '';
                    if(!is_null($item->deal_id) && is_null($item->business_service_id) && is_null($item->product_id)) {
                        $item_name ='<a href="javascript:;" class="view-deal" data-row-id="'.$item->deal_id.'">'.ucwords($item->deal->title). '</a><br> <small class="badge-pill badge-primary " >Deal</small>';
                    }
                    else if(is_null($item->deal_id) && is_null($item->business_service_id) && !is_null($item->product_id)) {
                        $item_name = $item->product->name.'<br> <small class="badge-pill badge-secondary " >Product</small>';
                    }
                    else if(is_null($item->deal_id) && !is_null($item->business_service_id) && is_null($item->product_id)) {
                        $item_name = ucwords($item->businessService->name).'<br> <small class="badge-pill badge-info " >Service</small>';
                    }
                @endphp

                <tr>
                    <td>{{ $key+1 }}.</td>
                    <td>{!! $item_name !!} </td>
                    <td>{{ $settings->currency->currency_symbol.number_format((float)$item->unit_price, 2, '.', '') }}</td>
                    <td>x{{ $item->quantity }}</td>
                    <td class="text-right">{{ $settings->currency->currency_symbol.number_format(($item->unit_price * $item->quantity), 2, '.', '')}}</td>
                </tr>
            @endforeach
            </tbody>

        </table>
    </div>
    <div class="col-md-7 border-top">
        <div class="row">
            <div class="col-md-12">
                <table class="table table-condensed">
                    <tr class="h6">
                        <td class="border-top-0">@lang('modules.booking.paymentMethod')</td>
                        <td class="border-top-0 "><i class="fa fa-money"></i> {{ $booking->payment_gateway }}</td>
                    </tr>
                    <tr class="h6">
                        <td>@lang('modules.booking.paymentStatus')</td>
                        <td>
                            @if($booking->payment_status == 'completed')
                                <span class="text-success  font-weight-normal"><i class="fa fa-check-circle"></i> {{ __('app.'.$booking->payment_status) }}</span></td>
                            @endif
                            @if($booking->payment_status == 'pending')
                                <span class="text-warning font-weight-normal"><i class="fa fa-times-circle"></i> {{ __('app.'.$booking->payment_status) }}</span></td>
                            @endif
                    </tr>

                    @if ($commonCondition)
                    <tr>
                        <td colspan="2">
                            <div class="payment-type">
                                <h5>@lang('front.paymentMethod')</h5>
                                <div class="payments text-center">
                                    @if($credentials->stripe_status == 'active')
                                    <a href="javascript:;" id="stripePaymentButton" data-bookingId="{{ $booking->id }}" class="btn btn-custom btn-blue mb-2"><i class="fa fa-cc-stripe mr-2"></i>@lang('front.buttons.stripe')</a>
                                    @endif
                                    @if($credentials->paypal_status == 'active')
                                    <a href="{{ route('front.paypal', $booking->id) }}" class="btn btn-custom btn-blue mb-2"><i class="fa fa-paypal mr-2"></i>@lang('front.buttons.paypal')</a>
                                    @endif
                                    @if($credentials->razorpay_status == 'active')
                                    <a href="javascript:;" id="razorpayButton" class="btn btn-custom btn-blue mb-2"><i class="fa fa-card mr-2"></i>@lang('front.buttons.razorpay')</a>
                                    @endif
                                    @if($credentials->offline_payment == 1)
                                    <a href="{{ route('front.offline-payment', ['bookingId'=>$booking->id, 'return_url'=>$current_url]) }}" id="offlineButton" class="btn btn-custom btn-blue mb-2"><i class="fa fa-money mr-2"></i>@lang('app.offline')</a>
                                    @endif
                                </div>
                            </div>
                        </td>
                    </tr>
                    @endif

                    @if($booking->status == 'completed')
                    <tr>
                        <td>
                            <a href="{{ route('admin.bookings.download', $booking->id) }}" class="btn btn-success btn-sm"><i class="fa fa-download"></i> @lang('app.download') @lang('app.receipt')</a>
                        </td>
                    </tr>
                    @endif
                </table>
            </div>
        </div>
    </div>

    <?php
      if (!isset($sub_total)) {
        $sub_total = 0;
      }

      if (!isset($estimated_vat)) {
        $estimated_vat = 0;
      }

      if (!isset($including_vat)) {
        $including_vat = 0;
      }
    ?>

    <div class="col-md-5 border-top amountDetail">
        <div class="row">
            <div class="col-md-12">
                <table class="table table-condensed">
                    <tr class="h6">
                        <td class="border-top-0 text-right">@lang('app.serviceSubTotal')</td>
                        <td class="border-top-0">{{ $settings->currency->currency_symbol.number_format((float)$sub_total, 2, '.', '') }} </td>
                    </tr>
                    <tr class="h6">
                        <td class="border-top-0 text-right">Estimated VAT</td>
                        <td class="border-top-0">{{ $settings->currency->currency_symbol.number_format((float)$estimated_vat, 2, '.', '') }} </td>
                    </tr>
                    <tr class="h6">
                        <td class="border-top-0 text-right">Total Including VAT</td>
                        <td class="border-top-0">{{ $settings->currency->currency_symbol.number_format((float)$including_vat, 2, '.', '') }} </td>
                    </tr>
                    @if($booking->discount > 0)
                    <tr class="h6">
                        <td class="text-right">@lang('app.discount')</td>
                        <td>{{ $settings->currency->currency_symbol.number_format((float)$booking->discount, 2, '.', '') }}</td>
                    </tr>
                    @endif

                    @if($booking->tax_amount > 0)
                    <tr class="h6" style="display:none">
                        <td class="text-right">{{ $booking->tax_name.' ('.$booking->tax_percent.'%)' }}</td>
                        <td>{{ $settings->currency->currency_symbol.number_format((float)$booking->tax_amount, 2, '.', '') }}</td>
                    </tr>
                    @endif

                    @if($booking->coupon_discount > 0)
                    <tr class="h6">
                        <td class="text-right" >@lang('app.couponDiscount') (<a href="javascript:;" class="show-coupon">{{ $booking->coupon->title}}</a>)</td>
                        <td>{{ $settings->currency->currency_symbol.number_format((float)$booking->coupon_discount, 2, '.', '') }}</td>
                    </tr>
                    @endif
                    <tr class="h6">
                        <td class="border-top-0 text-right">@lang('app.service') @lang('app.total')</td>
                        <td class="border-top-0">{{ $settings->currency->currency_symbol.number_format((float)
                        $booking->amount_to_pay - $booking->product_amount, 2, '.', '') }} </td>
                    </tr>
                    @if ($booking->product_amount > 0)
                    <tr class="h6">
                        <td class="border-top-0 text-right">@lang('app.product') @lang('app.total')</td>
                    <td class="border-top-0">{{ $settings->currency->currency_symbol.number_format((float)$booking->product_amount, 2, '.', '') }}</td>
                    </tr>
                    @endif
                    <tr class="h5">
                        <td class="text-right">@lang('app.grand') @lang('app.total')</td>
                        <td>{{ $settings->currency->currency_symbol.number_format((float)$booking->amount_to_pay, 2, '.', '') }}</td>
                    </tr>
                </table>
            </div>
        </div>

    </div>

    @if(!is_null($booking->additional_notes))
    <div class="col-md-12 font-italic">
        <h4 class="text-info">@lang('modules.booking.customerMessage')</h4>
        <p class="text-lg">
            {!! $booking->additional_notes !!}
        </p>
    </div>
    @endif
    {{--coupon detail Modal--}}
    <div class="modal fade bs-modal-lg in" id="coupon-detail-modal" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" id="modal-data-application">
            <div class="modal-content">

                <div class="modal-header">
                    <h4 class="modal-title">@lang('app.coupon')</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body">

                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times"></i> @lang('app.close')</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    {{--coupon detail Modal Ends--}}
</div>

<script>
    $('body').on('click', '#offlineButton, #stripePaymentButton, #razorpayButton', function()
    {
        if ($('a').hasClass('disabled')) {
            $('a').removeClass('disabled');
        } else {
            $('a').addClass('disabled');
        }
    });
</script>

<script>
    @if($booking->coupon_discount > 0)
        $('body').on('click', '.show-coupon', function() {
            var url = '{{ route('admin.coupons.show', $booking->coupon_id)}}';
            $('#modelHeading').html('Show Coupon');
            $.ajaxModal('#coupon-detail-modal', url);
        });
    @endif
</script>

@if($credentials->stripe_status == 'active')
<script>

    var stripe = Stripe('{{ $credentials->stripe_client_id }}');
    var checkoutButton = document.getElementById('stripePaymentButton');
    var current_url = '{{ $current_url }}';

    checkoutButton.addEventListener('click', function() {
        $.easyAjax({
            url: '{{route('front.stripe')}}',
            container: '#invoice_container',
            type: "POST",
            redirect: true,
            async: false,
            data: {"_token" : "{{ csrf_token() }}",
                    'booking_id' : {{$booking->id }},
                    'return_url' :  current_url,
            },
            success: function(response){

                stripe.redirectToCheckout({
                    sessionId: response.id,

                }).then(function (result) {
                    if (result.error) {
                        $.easyAjax({
                            url: '{{route('front.redirectToErrorPage')}}',
                        });
                    }
                });
            },
        });
    });
</script>
@endif

@if($credentials->razorpay_status == 'active')
<script>
    // put customer in razorpay payment flow
    var options = {
        key: "{{ $credentials->razorpay_key }}", // Enter the Key ID generated from the Dashboard
        amount: "{{ $booking->amount_to_pay * 100 }}", // Amount is in currency subunits. Default currency is INR. Hence, 50000 refers to 50000 paise
        currency: "{{ $settings->currency->currency_code }}",
        name: "{{ $booking->user->name }}",
        description: "@lang('app.booking') @lang('front.headings.payment')",
        image: "{{ $setting->logo_url }}",
        order_id: "{{ $booking->order_id }}", //This is a sample Order ID. Pass the `id` obtained in the response of Step 1
        current_url: "{{ $current_url }}",

        "handler": function (response){
            $.easyAjax({
                url: "{{ route('front.razorpay.verifyPayment') }}",
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    razorpay_payment_id: response.razorpay_payment_id,
                    razorpay_order_id: response.razorpay_order_id,
                    order_id: '{{ $booking->order_id }}',
                    razorpay_signature: response.razorpay_signature,
                    return_url: current_url,
                },
                container: '#invoice_container',
                redirect: true,

            })
        },
        prefill: {
            name: "{{ $booking->user->name }}",
            email: "{{ $booking->user->email }}",
            contact: "{{ $booking->user->mobile }}"
        },
        notes: {
            booking_id: "{{ $booking->id }}"
        },
        theme: {
            color: "{{ $frontThemeSettings->primary_color }}"
        }
    };
    var rzp1 = new Razorpay(options);
    document.getElementById('razorpayButton').onclick = function(e){
        rzp1.open();
        e.preventDefault();
    }
</script>
@endif


