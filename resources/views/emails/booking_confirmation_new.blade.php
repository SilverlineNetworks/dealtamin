<!DOCTYPE html>
<html lang="en" >
    <head>
      <meta charset="UTF-8">
      <title>{{__('email.bookingConfirmation.text')}}</title>
      <style type="text/css">
          body{
              width:100% !important;
              -webkit-text-size-adjust:100%;
              -ms-text-size-adjust:100%;
              margin:0 auto;
              padding:0;
              background-color:#e3e3e3;
              text-align: center;
              align-items: center;
              display: flex;
              justify-content: center;
          }
          * {-webkit-font-smoothing:antialiased}
          .ExternalClass * {line-height:100%}
          table td {border-collapse:collapse; max-width:100% !important; word-break:break-word; -webkit-hyphens:auto; -moz-hyphens:auto; hyphens:auto; overflow:auto; white-space:normal;}
          .wlf {width:610px}
          @media only screen and (max-width:610px) {
              .full-width {width:100% !important}
              .t-none {display:none}
              .t-center-txt {text-align:center}
              .t-width {width:100% !important;max-width:100% !important;display:table !important}
          }
          img {
              width: 200px;
          }
      </style>
    </head>

    <body>
        <div style="font-size:1px;color:#333333;line-height:1px;max-height:0px;max-width:0px;opacity:0;overflow:hidden;">
            {{__('email.bookingConfirmation.text')}}
        </div>
        <div style="padding:10px;width: 60%;background-color:#fff; text-align:left">
            <div style="text-align:center">
                <img src="{{asset('user-uploads/logo/1ce0be83858744699542be0e4daf93e2.png')}}" class="logo" alt="Laravel Logo">
            </div>
            <table width="100%">
                <tr>
                    <td>Hi <b>{{$name}}</b></td>
                </tr>
                <tr>
                    <td>
                        <div style="margin-top:10px;margin-bottom:10px;">{{__('email.bookingConfirmation.text')}}</div>

                        <table style="width:60%">
                            <tr>
                                <td style="color:#109191;">Booking Number</td>
                                <td>{{$booking_id}}</td>
                            </tr>
                            <tr>
                                <td style="color:#109191;">Booking Date and Time</td>
                                <td>{{$booking_date}}</td>
                            </tr>
                            <tr>
                                <td style="color:#109191;">Payment Method</td>
                                <td>{{$payment_method}}</td>
                            </tr>
                            <tr>
                                <td style="color:#109191;">Vendor</td>
                                <td>{{$vendor_name}}</td>
                            </tr>
                        </table>

                        <div style="margin-top:30px;margin-bottom:30px;">Service Details</div>

                        <table border="0" cellspacing="0" cellpadding="0" style="width:100%">
                            <thead>
                                <tr>
                                    <th class="no">#</th>
                                    <th class="desc"><b>@lang("app.item")</b></th>
                                    <th class="qty"><b>@lang("app.quantity")</b></th>
                                    <th class="qty"><b>@lang("app.unitPrice")</b></th>
                                    <th class="unit"><b>@lang("app.amount")</b></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    $count = 0;
                                ?>
                                @foreach ($booking->items as $key => $item)

                                    @php
                                        $item_name = '';
                                        if(!is_null($item->deal_id) && is_null($item->business_service_id) && is_null($item->product_id)) {
                                            $item_name = ucwords($item->deal->title);
                                        }
                                        else if(is_null($item->deal_id) && is_null($item->business_service_id) && !is_null($item->product_id)) {
                                            $item_name = ucwords($item->product->name);
                                        }
                                        else if(is_null($item->deal_id) && !is_null($item->business_service_id) && is_null($item->product_id)) {
                                            $item_name = ucwords($item->businessService->name);
                                        }
                                    @endphp


                                    <tr class="pgi">
                                        <td class="no">{{ ++$count }}</td>
                                        <td class="desc">
                                            <h3>{{ $item_name }} </h3>
                                        </td>
                                        <td class="qty">
                                            <h3>{{ $item->quantity }}</h3>
                                        </td>
                                        <td class="qty">
                                            <h3>
                                                <span class="ff">{{ $settings->currency->currency_symbol }}</span>
                                                {{ number_format((float) $item->unit_price, 2, '.', '') }}
                                            </h3>
                                        </td>
                                        @if (!is_null($booking->deal_id))
                                            <td class="unit">
                                                <span class="ff">{{ $settings->currency->currency_symbol }}</span>
                                                {!! number_format((float) ($item->unit_price * $item->quantity), 2, '.', '') !!}
                                            </td>
                                        @else
                                            <td class="unit">
                                                <span class="ff">{{ $settings->currency->currency_symbol }}</span>
                                                {!! number_format((float) ($item->unit_price * $item->quantity), 2, '.', '') !!}
                                            </td>
                                        @endif
                                    </tr>
                                @endforeach
                                @if (!is_null($item->business_service_id))
                                <tr class="subtotal pgi">
                                    <td class="no">&nbsp;</td>
                                    <td class="qty">&nbsp;</td>
                                    <td class="qty">&nbsp;</td>
                                    <td class="desc">@lang('app.service') @lang("app.subTotal")</td>
                                    <td class="unit">
                                        <span class="ff">{{ $settings->currency->currency_symbol }}</span>
                                        {{ number_format((float) $booking->original_amount, 2, '.', '') }}
                                    </td>
                                </tr>
                                @endif
                                @if ($booking->discount > 0)
                                    <tr class="discount pgi">
                                        <td class="no">&nbsp;</td>
                                        <td class="qty">&nbsp;</td>
                                        <td class="qty">&nbsp;</td>
                                        <td class="desc">@lang("app.discount")</td>
                                        <td class="unit">-
                                            <span class="ff">{{ $settings->currency->currency_symbol }}</span>
                                            {{ number_format((float) $booking->discount, 2, '.', '') }}
                                        </td>
                                    </tr>
                                @endif
                                @if ($booking->tax_amount > 0)
                                    <tr class="tax pgi">
                                        <td class="no">&nbsp;</td>
                                        <td class="qty">&nbsp;</td>
                                        <td class="qty">&nbsp;</td>
                                        <td class="desc">{{ $booking->tax_name . ' (' . $booking->tax_percent . '%)' }}</td>
                                        <td class="unit">
                                            <span class="ff">{{ $settings->currency->currency_symbol }}</span>
                                            {{ number_format((float) $booking->tax_amount, 2, '.', '') }}
                                        </td>
                                    </tr>
                                @endif
                                <tr class="subtotal pgi">
                                    <td class="no">&nbsp;</td>
                                    <td class="qty">&nbsp;</td>
                                    <td class="qty">&nbsp;</td>
                                    <td class="desc">@lang('app.service') @lang('app.total')</td>
                                    <td class="unit">
                                        <span class="ff">{{ $settings->currency->currency_symbol }}</span>
                                        {{ number_format((float) $booking->amount_to_pay - $booking->product_amount, 2, '.', '') }}
                                    </td>
                                </tr>
                                <tr class="subtotal pgi">
                                    <td class="no">&nbsp;</td>
                                    <td class="qty">&nbsp;</td>
                                    <td class="qty">&nbsp;</td>
                                    <td class="desc">@lang('app.product') @lang('app.total')</td>
                                    <td class="unit">
                                        <span class="ff">{{ $settings->currency->currency_symbol }}</span>
                                        {{ number_format((float) $booking->amount_to_pay, 2, '.', '') }}
                                    </td>
                                </tr>
                            </tbody>
                            <tfoot>
                                <tr dontbreak="true">
                                    <td colspan="4">@lang("app.grand") @lang("app.total")</td>
                                    <td id="ta">
                                        <span class="ff">{{ $settings->currency->currency_symbol }}</span>
                                        {{ number_format((float) $booking->amount_to_pay, 2, '.', '') }}
                                    </td>
                                </tr>
                            </tfoot>
                        </table>


                        <p>We’re committed to addressing any issues that come up during your service with us. If you have any comments on how we can improve, please give us a call at +971554592638</p>

                        <p>We hope that you’ll book with us again soon.</p>

                        <p>{{__('email.thankyouNote')}}</p>
                    </td>
                </tr>
            </table>
        </div>
    </body>
</html>
