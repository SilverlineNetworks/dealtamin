@extends('layouts.front')

@push('styles')
    <link href="{{ asset('front/css/cart.css') }}" rel="stylesheet">
    <link href=" {{ asset('front/css/bootstrap-datepicker.css') }} " rel="stylesheet">
    <link href=" {{ asset('front/css/booking-step-1.css') }} " rel="stylesheet">
    <style>
        .d-none {
            display: none;
        }
        .CouponBox {
            border-radius: 4px;
            overflow: hidden;
        }
        #msg_div {
            color: crimson;
        }
    </style>
@endpush

@section('content')
    <!-- CART START -->
    <section class="booking_step_section">
        <div class="container">
            <div class="row ">
                <div class="col-12">
                    <div class="booking_step_heading text-center">
                        <h1 class="text-left">@lang('front.headings.bookingDetails')</h1>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-8 col-12 mb-30">
                    <div class="shopping-cart-table">
                        <table class="table table-responsive-md">
                            <thead>
                                <tr>
                                    <th>@lang('front.table.headings.serviceName')</th>
                                    <th>@lang('front.table.headings.unitPrice')</th>
                                    <th>@lang('front.table.headings.quantity')</th>
                                    <th>@lang('front.table.headings.subTotal')</th>
                                    @if (!is_null($products))
                                        <th>&nbsp;</th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody>
                                @if (!is_null($products))
                                    @foreach($products as $key => $product)
                                        <tr id="{{ $key }}">
                                            <td>{{ $product['name'] }}
                                            </td>
                                            <td class="rupee">{{ $settings->currency->currency_symbol.$product['price'] }}</td>
                                            <td>
                                                <div></div>
                                                <div class="qty-wrap">
                                                    <div class="value-button qty-elements decrease" value="Decrease Value"><i class="zmdi zmdi-minus"></i></div>

                                                    <input
                                                    type="number"
                                                    id="number"
                                                    name="qty"
                                                    onkeypress="return isNumberKey(event)"
                                                    value="{{ $product['quantity'] }}"
                                                    class="input-text qty"
                                                    data-id="{{ $product['unique_id'] }}"
                                                    data-deal-id="{{ $product['id'] }}"
                                                    data-price="{{$product['price']}}"
                                                    data-type="{{$product['type']}}"
                                                    @if ($product['type'] == 'deal')
                                                        data-max-order="{{$product['max_order']}}"
                                                    @endif
                                                    autocomplete="none">

                                                    <div class="value-button qty-elements increase" value="Increase Value"><i class="zmdi zmdi-plus"></i></div>
                                                </div>
                                            </td>

                                            <td class="sub-total rupee">
                                                {{ $settings->currency->currency_symbol }}<span data-taxtype={{$product['tax_type']}} data-taxpercentage={{$product['tax_percentage']}}>{{ $product['quantity'] * $product['price'] }}</span>
                                            </td>
                                            <td>
                                                <a title="@lang('front.table.deleteProduct')" href="javascript:;" data-key="{{ $key }}" class="delete-item delete-btn">
                                                    <i class="fa fa-trash"></i>
                                                </a>
                                            </td>

                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="4" class="text-center text-danger">@lang('front.table.emptyMessage')</td>
                                    </tr>
                                @endif
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="5">
                                        <ul class="cart-buttons">
                                            <li>
                                            </li>
                                            <li>
                                                <a href="javascript:;" data-key="all" class="btn btn-custom btn-blue delete-item" id="clear-cart">@lang('front.buttons.clearCart')</a>
                                                <a href="{{ route('front.index') }}" class="btn btn-custom btn-blue">@lang('front.buttons.continueBooking')</a>
                                            </li>
                                        </ul>
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
                <div class="col-lg-4 col-12 mb-30">

                    <div class="cart-block mt-3 mt-lg-0">
                        <div class="final-cart">
                            <h5>@lang('front.summary.cart.heading.cartTotal')</h5>
                            <div class="mx-3 mt-4">
                                <div>
                                    <span style="text-transform: capitalize;font-size: 14px;color: #3b3b3b;">Booking Date</span>
                                </div>
                                <input min="<?=date('Y-m-d', time());?>" type="date" name="booking_date" id="booking_date" class="form-control" data-date-format="YYYY MMMM DD" style="border:1px solid #ced4da"/>
                            </div>

                            <div class="mx-3 mt-4">
                                <div>
                                    <span style="text-transform: capitalize;font-size: 14px;color: #3b3b3b;">Booking Time</span>
                                </div>
                                <select class="form-control" id="bk_time">

                                </select>
                            </div>

                            @if ($type == 'booking')
                                <div class="mx-3 mt-4 @if(is_null($couponData)) CouponBox @else d-none @endif" id="applyCouponBox">
                                    <div class="input-group">
                                        <input type="text" name="coupon" class="form-control" placeholder="@lang('front.summary.cart.applyCoupon')" id="coupon">
                                        <div class="input-group-prepend">
                                            <button id="apply-coupon" type="button" class="mt-2 mt-lg-0 mt-md-0 btn btn-sm input-group-text">@lang('front.summary.cart.applyCoupon')</button>
                                        </div>
                                    </div>
                                </div>

                                <div class="pb-0 cart-value @if(is_null($couponData)) d-none @endif" id="removeCouponBox">
                                    <h6  class="clearfix">@lang('app.coupons')</h6>
                                    <div class="coupons-base-content justify-content-between d-flex align-items-center">
                                        <div class="d-flex align-items-center">
                                            <div>
                                                <span class="coupons-name mb-0 text-uppercase" id="couponCode" >
                                                    @if(!is_null($couponData))
                                                        {{ $couponData[0]['code'] }}
                                                    @endif
                                                </span>
                                                <small class="mb-0 text-success savetext d-block">
                                                    @lang('app.youSaved')
                                                    <span id="couponCodeAmonut" class="rupee">
                                                        @if(!is_null($couponData))
                                                            {{ $settings->currency->currency_symbol }}{{ $couponData['applyAmount'] }}
                                                        @endif
                                                    </span>
                                                </small>
                                            </div>
                                        </div>
                                        <div>
                                            <button id="remove-coupon" type="button" class="btn btn-sm btn-danger remove-button"> @lang('app.remove') </button>
                                        </div>
                                    </div>
                                </div>
                            @endif

                            <div class="cart-value">
                                <ul class="cart-value-detail">

                                    @if($type == 'booking')
                                        <li>
                                            <span>
                                                @lang('front.summary.cart.subTotal')
                                            </span>
                                            <span id="sub-total" class="rupee">
                                            </span>
                                        </li>
                                    @endif

                                    @if($type == 'booking')
                                        @if(!is_null($tax) && !is_null($products))
                                            <li class="couponDiscountBox">
                                                <span>
                                                    {{ $tax->tax_name }}:
                                                </span>
                                                <span id="tax" class="rupee">
                                                </span>
                                            </li>
                                        @endif
                                    @endif

                                    @if($type == 'booking')
                                        @if(!is_null($couponData))
                                            <li class="couponDiscountBox" id="couponDiscountBox">
                                                <span class="text-uppercase">
                                                    @lang('app.discount') ({{ $couponData[0]['code'] }}):
                                                </span>
                                                <span id="couponDiscoiunt">
                                                    -{{ $settings->currency->currency_symbol }}{{ $couponData['applyAmount'] }}
                                                </span>
                                            </li>
                                        @endif
                                    @endif


                                </ul>
                                <ul class="cart-total-amount">
                                    <li id="totalAmountBox" class="mb-0">
                                        <span>
                                            @lang('front.summary.cart.totalAmount'):
                                        </span>
                                        <span id="total" class="rupee">
                                        </span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row hide" style="display: none">
                <div class="col-12">
                    <div class="booking_step_heading text-center">
                        <h1 class="text-left">@lang('front.headings.bookingdatetime')</h1>
                    </div>
                </div>
                <div class="col-5">
                    <input min="<?=date('Y-m-d', time());?>" type="date" id="booking_datesss" class="form-control" data-date-format="YYYY MMMM DD" style="border:solid 10px #efefef"/><div class="mx-auto" ></div>
                </div>
                <div class="col-7">
                    <div class="dropdown" style="border:solid 10px #efefef;border-top-right-radius: 30px;padding-top: 5px;padding-bottom: 5px;padding-left: 10px;border-bottom-right-radius: 30px;">
                        <a class="dropdown-toggle" href="" data-toggle="dropdown" aria-expanded="false" style="color:#000; width:100%">
                            Available Appointments On <span id="select-id"></span>
                        </a>
                        <div class="dropdown-menu bg-white rounded">
                          <div class="container">
                            <div class="row">
                                <div style="width:100%;">
                                    <input type="hidden" id="booking_dated" name="booking_dated">
                                    <div class="slots-wrapper" style="display:none"></div>
                                </div>
                            </div>
                          </div>
                        </div>
                    </div>
                </div>
            </div>

            @if (!is_null($products))
                <div class="row">
                    <div class="col-12 d-flex justify-content-between booking_step_buttons">
                        <button class="btn d-flex align-items-center go-back"><i class="zmdi zmdi-long-arrow-left"></i>@lang('front.navigation.goBack')
                        </button>
                        <a id="nextBtn" href="javascript:;" class="btn btn-custom btn-dark add-booking-details">@lang('front.navigation.toCheckout') <i class="zmdi zmdi-long-arrow-right"></i></a>
                        <!--<button class="btn d-flex align-items-center next-step hide">
                            {{ (!is_null($type) && $type == 'deal') ? __('front.navigation.toCheckout') : __('front.selectBookingTime') }}
                            <i class="zmdi zmdi-long-arrow-right"></i>
                        </button>-->
                    </div>
                </div>
            @endif
        </div>
    </section>
    <!-- CART END -->
@endsection

@push('footer-script')
    <script src="{{ asset('assets/js/cookie.js') }}"></script>
    <script src="{{ asset('front/js/bootstrap-datepicker.min.js') }}"></script>

    <script>
        $("#booking_date").val('<?=date('Y-m-d', time());?>');
        $('#select-id').html('<?=date('Y-m-d', time());?>');
        var bookingDetails = {
            bookingDate : '<?=date('Y-m-d', time());?>'
        }

        $(function () {

            getBookingSlots({ bookingDate:  '<?=date('Y-m-d', time());?>', _token: "{{ csrf_token() }}"});

            @if (sizeof($bookingDetails) > 0)
                getBookingSlots({ bookingDate:  '{{ $bookingDetails['bookingDate'] }}', _token: "{{ csrf_token() }}"});
                var bookingDate = '{{ $bookingDetails['bookingDate'] }}';
                bookingDetails.bookingDate = bookingDate;
                $("#booking_date").val(bookingDate);
                //$('#datepicker').datepicker('update', dateFormat(new Date(bookingDate), 'yyyy-mm-dd', true));
                //$('#datepicker').val(dateFormat(new Date(bookingDate), 'yyyy-mm-dd', true));
                //$('#select-id').html(dateFormat(new Date(bookingDate), 'yyyy-mm-dd', true));
            @endif
        });

        /*$('#datepicker').datepicker({
            startDate: '-0d',
            format: "yyyy-mm-dd"
        });*/

        $('#booking_date').change(function(){
            //var formattedDate = $('#datepicker').datepicker('getFormattedDate');
            var formattedDate = $('#booking_date').val();

            var d = new Date(formattedDate);
            var year = d.getFullYear();
            var month = d.getMonth()+1;
            var day = d.getDate();

            month = month.toString().length == 1 ? '0'+month : month ;
            day = day.toString().length == 1 ? '0'+day : day ;

            bookingDetails.bookingDate = year+'-'+month+'-'+day;
            $('#select-id').html(bookingDetails.bookingDate);
            getBookingSlots({ bookingDate:  bookingDetails.bookingDate, _token: "{{ csrf_token() }}"})
        })

        $('#datepicker').on('changeDate', function() {
          $('.slots-wrapper').css({'display': 'flex', 'align-items': 'center'});
          var initialHeight = $('.slots-wrapper').css('height');
          var html = '<div class="loading text-white d-flex align-items-center" style="height: '+initialHeight+';">Loading... </div>';
          $('.slots-wrapper').html(html);

          /*$('html, body').animate({
              scrollTop: $(".slots-wrapper").offset().top
          }, 1000);*/

          var formattedDate = $('#datepicker').datepicker('getFormattedDate');
          $('#booking_date').val(formattedDate);
          var d = new Date(formattedDate);
          var year = d.getFullYear();
          var month = d.getMonth()+1;
          var day = d.getDate();

          month = month.toString().length == 1 ? '0'+month : month ;
          day = day.toString().length == 1 ? '0'+day : day ;

          bookingDetails.bookingDate = year+'-'+month+'-'+day;

          getBookingSlots({ bookingDate:  bookingDetails.bookingDate, _token: "{{ csrf_token() }}"})
        });

        var bookingDetails = {_token: $("meta[name='csrf-token']").attr('content')};

        $("#bk_time").change(function(){
            if ($(this).val() != '0') {
                bookingDetails.bookingTime = $(this).val().toString();
            }
        });

        function getBookingSlots(data) {
            $('#msg_div').html('');
            $.easyAjax({
                url: "{{ route('front.bookingSlots') }}",
                type: "POST",
                blockUI: false,
                data: data,
                success: function (response) {
                    if(response.status == 'success') {
                        //$('.slots-wrapper').html(response.view);
                        $("#bk_time").html('<option value="0">--Select--</option>' + response.view);
                        // check for cookie
                        @if (sizeof($bookingDetails) > 0)
                        $('.slots-wrapper').css('display', 'flex');

                            var bookingTime = '{{ $bookingDetails['bookingTime'] }}';
                            var bookingDate = '{{ $bookingDetails['bookingDate'] }}';
                            var emp_name    = '{{ $bookingDetails['emp_name'] }}';

                            if (bookingDate == bookingDetails.bookingDate) {
                                bookingDetails.bookingTime = bookingTime;
                                //$(`input[value='${bookingTime}']`).attr('checked', true);
                                //if(emp_name == ''){ emp_name = '@lang("app.noEmployee")';  }
                                //$('#show_emp_name_div').show();
                                //$('#show_emp_name_div').html(emp_name+' @lang("front.isSelectedForBooking")..!');

                            } else {
                                bookingDetails.bookingTime = '';
                            }
                        @else
                        bookingDetails.bookingTime = '';
                        @endif
                    } else {
                        $('.slots-wrapper').html('');
                        $('.slots-wrapper').css('display', 'none');
                        $('#msg_div').html(response.msg);
                    }
                    $('#selectedBookingDate').html(data.bookingDate);
                }
            })
        }

        function isNumberKey(evt){
            var charCode = (evt.which) ? evt.which : evt.keyCode
            if (charCode > 31 && (charCode < 48 || charCode > 57))
            return false;
            return true;
        }

        $(function () {
            var couponCode = '';
            calculateTotal();
        });

        var cartUpdate;
        var couponAmount = 0;
        var couponApplied = false;
        var products = {!! json_encode($products) !!};

        @if(!is_null($couponData) && $couponData['applyAmount'])
            couponAmount = '{{ $couponData['applyAmount'] }}';
            couponCode = '{{ $couponData[0]['code'] }}';
            couponApplied = true;
        @endif

        function calculateTotal() {
            let cartTotal = tax = totalAmount = 0.00;
            let taxType = 2;
            let taxPercentage = 0;

            $('.sub-total>span').each(function () {
                cartTotal += parseFloat($(this).text());
                taxType = $(this).data('taxtype');
                taxPercentage = $(this).data('taxpercentage');
            });

            $('#sub-total').text('{{ $settings->currency->currency_symbol }}'+cartTotal.toFixed(2));

            // calculate and display tax
            @if($type=='booking')
                if (taxType == 1) {
                    let taxPercent = parseFloat(taxPercentage);
                    tax = (taxPercent * cartTotal)/100;
                }

                $('#tax').text('{{ $settings->currency->currency_symbol }}'+tax.toFixed(2));
            @endif

            totalAmount = cartTotal + tax;

            if(couponAmount)
            {
                if(totalAmount>=couponAmount)
                {
                    totalAmount = totalAmount - couponAmount;
                }
                else
                {
                    totalAmount = 0;
                }
            }

            $('#total').text('{{ $settings->currency->currency_symbol }}'+totalAmount.toFixed(2));
        }

        $('body').on('click', '#remove-coupon', function() {
            removeCoupon();
        });

        $('body').on('click', '.increase', function() {
            var input = $(this).siblings('input');
            var currentValue = input.val();

            const type = input.data('type');
            const dealId = input.data('deal-id');

            if(currentValue>0) {
                input.val(parseInt(currentValue) + 1);
                input.trigger('keyup');
            }
        });

        $('body').on('click', '.decrease', function() {
            var input = $(this).siblings('input');
            var currentValue = input.val();

            if (currentValue > 1) {
                input.val(parseInt(currentValue) - 1);
                input.trigger('keyup');
            }
        });

        $('body').on('click', '.delete-item', function() {
            let ele = $(this);
            let key = $(this).data('key');

            var url = '{{ route('front.deleteProduct', ':id') }}';
            url = url.replace(':id', key);

            $.easyAjax({
                url: url,
                type: 'POST',
                data: {_token: $("meta[name='csrf-token']").attr('content')},
                redirect: false,
                blockUI: false,
                disableButton: true,
                buttonSelector: "#clear-cart",
                success: function (response) {
                    if (response.status == 'success') {
                        if (response.action == "redirect") {
                            var message = "";
                            if (typeof response.message != "undefined") {
                                message += response.message;
                            }

                            $.showToastr(message, "success", {
                                positionClass: "toast-top-right"
                            });

                            setTimeout(function () {
                                window.location.href = response.url;
                            }, 1000);
                        } else{
                            updateCoupon ();
                            $(ele).parents(`tr#${key}`).remove();
                            calculateTotal();
                            $('.cart-badge').text(response.productsCount);
                            products = response.products;
                        }
                    }
                }
            })
        });

        function updateCart(ele) {
            let data = {};
            let currentValue = ele.val();
            let type = ele.data('type');
            let max_order = ele.data('max-order');
            let unique_id = ele.data('id');
            let price = ele.data('price');

            let showError = false;

            $('input.qty').each(function () {
                const serviceId = $(this).data('id');
                products[serviceId].quantity = parseInt($(this).val());
            });

            if(type == 'deal' && parseInt(currentValue) > parseInt(max_order)) {
                showError = true;
                ele.val(parseInt(max_order));

                totalAmount = 0;
                $('input.qty').each(function () {
                    let quantity = $(this).val();
                    let price = $(this).data('price');
                    let id = $(this).data('id');

                    let subTotal = parseInt(quantity) * parseInt(price);
                    totalAmount += subTotal;
                    $(`tr#${id}`).find('.sub-total>span').text(subTotal.toFixed(2));
                });

                $('#total').text('{{ $settings->currency->currency_symbol }}'+totalAmount.toFixed(2));
            }

            data.showError = showError;
            data.products = products;
            data.currentValue = currentValue;
            data.type = type;
            data.max_order = max_order;
            data.unique_id = unique_id;
            data._token = '{{ csrf_token() }}';


            if($('input.qty').val()>=0 && $('input.qty').val()!='') {
                $.easyAjax({
                    url: '{{ route('front.updateCart') }}',
                    type: 'POST',
                    data: data,
                    container: '.section',
                    blockUI: false,
                    success:function(response){
                        updateCoupon();
                    }
                })
            }
        }

        function removeCoupon() {
            $.easyAjax({
                url: '{{ route('front.remove-coupon') }}',
                type: 'GET',
                blockUI: false,
                disableButton: true,
                buttonSelector: "#remove-coupon",
                success: function (response) {
                    couponApplied = false;
                    $('#coupon').val('');
                    $('#coupon_amount').val(0);
                    couponAmount = 0;
                    calculateTotal();
                    $('#couponDiscountBox').remove();
                    $('#removeCouponBox').addClass('d-none');
                    $('#applyCouponBox').removeClass('d-none');
                    $('#applyCouponBox').addClass('CouponBox');
                }
            })
        }

        $('body').on('click', '#apply-coupon', function() {
            let cartTotal = tax = totalAmount = 0.00;

            $('.sub-total>span').each(function () {
                cartTotal += parseFloat($(this).text());
            });

            $('#sub-total').text('{{ $settings->currency->currency_symbol }}'+cartTotal.toFixed(2));

            // calculate and display tax
            @if(!is_null($tax))
                let taxPercent = parseFloat('{{ $tax->percent }}');
                tax = (taxPercent * cartTotal)/100;
                $('#tax').text('{{ $settings->currency->currency_symbol }}'+tax.toFixed(2));
            @endif

            totalAmount = cartTotal + tax;

           var couponVal = $('#coupon').val();

           if((couponVal === undefined || couponVal === "" || couponVal === null)){
               return $.showToastr("@lang('errors.coupon.required')", 'error');
           } else{
               var currencySymbol = '{{ $settings->currency->currency_symbol }}';
               $.easyAjax({
                    url: '{{ route('front.apply-coupon') }}',
                    type: 'GET',
                    data: {'coupon':couponVal},
                    blockUI: false,
                    disableButton: true,
                    buttonSelector: "#apply-coupon",
                    success: function (response) {
                        if(response.status != 'fail') {
                            couponApplied = true;
                            couponCode = couponVal;
                            couponAmount = response.amount;

                            if(couponAmount>totalAmount) {
                                couponAmount = totalAmount;
                            }

                            calculateTotal();
                            $('#couponDiscountBox').remove();
                            var discountElement = '<li id="couponDiscountBox">'+
                                '<span class="text-uppercase">'+
                                "@lang('app.discount') ("+response.couponData.code+'):'+
                                '</span>'+
                                '<span id="discountCoupon">-'+currencySymbol +couponAmount+
                                '</span>'+
                                '</li>';
                            $(discountElement).insertBefore( "#totalAmountBox" );

                            $('#applyCouponBox').addClass('d-none');
                            $('#applyCouponBox').removeClass('CouponBox');

                            $('#removeCouponBox').removeClass('d-none');

                            $('#couponCodeAmonut').html(couponAmount);
                            $('#couponCode').html(response.couponData.code);
                        } else{
                            removeCoupon ();
                        }
                    }
               })
           }
        });

        function updateCoupon() {

            let cartTotal = tax = totalAmount = 0.00;

            $('.sub-total>span').each(function () {
                cartTotal += parseFloat($(this).text());
            });

            $('#sub-total').text('{{ $settings->currency->currency_symbol }}'+cartTotal.toFixed(2));

            // calculate and display tax
            @if(!is_null($tax))
                let taxPercent = parseFloat('{{ $tax->percent }}');
                tax = (taxPercent * cartTotal)/100;
                $('#tax').text('{{ $settings->currency->currency_symbol }}'+tax.toFixed(2));
            @endif

            totalAmount = cartTotal + tax;

            if (couponApplied) {
                var currencySymbol = '{{ $settings->currency->currency_symbol }}';
                $.easyAjax({
                    url: '{{ route('front.update-coupon') }}',
                    type: 'GET',
                    data: {'coupon': couponCode},
                    blockUI: false,
                    success: function (response) {
                        if (response.status != 'fail') {
                            couponAmount = response.amount;

                            if(couponAmount>totalAmount) {
                                couponAmount = totalAmount;
                            }

                            calculateTotal();
                            $('#couponDiscountBox').remove();
                            var discountElement = '<li id="couponDiscountBox">' +
                                '<span class="text-uppercase">' +
                                "@lang('app.discount') (" + response.couponData.code + '):' +
                                '</span>' +
                                '<span id="discountCoupon">-' + currencySymbol + couponAmount +
                                '</span>' +
                                '</li>';
                            $(discountElement).insertBefore("#totalAmountBox");

                            $('#applyCouponBox').addClass('d-none');
                            $('#applyCouponBox').removeClass('CouponBox');

                            $('#removeCouponBox').removeClass('d-none');

                            $('#couponCodeAmonut').html(couponAmount);
                            $('#couponCode').html(response.couponData.code);
                        } else {
                            removeCoupon();
                        }

                    }
                })
            }
        }

        $(document).on('keyup', 'input.qty', function () {
            const id = $(this).data('id');
            const price = $(this).data('price');
            const quantity = $(this).val();

            const el = $(this);

            const type = $(this).data('type');
            const dealId = $(this).data('deal-id');

            let subTotal = 0;

            if (quantity<0) {
                $(this).val(1);
            }

            clearTimeout(cartUpdate);

            if (quantity == '' || quantity == 0) {
                subTotal = price * 1;
            }
            else {
                subTotal = price * quantity;
            }

            $(`tr#${id}`).find('.sub-total>span').text(subTotal.toFixed(2));
            calculateTotal();

            cartUpdate = setTimeout(() => {
                updateCart($(this));
            }, 500);

        });

        $(document).on('blur', 'input.qty', function () {
            if ($(this).val() == '' || $(this).val() == 0) {
                $(this).val(1);
            }
        })

        $('body').on('click', '.go-back', function() {
            var url = "{{ route('front.index') }} ";
            window.location.href = url;
        });

        $('body').on('click', '.next-step', function() {

            @php
                $url = (!is_null($type) && $type == 'deal') ? route('front.checkoutPage') : route('front.bookingPage');
            @endphp

            var url = "{{ $url }}";alert(url);
            window.location.href = url;
        });

        $(document).on('change', $('select[id="bk_time"]'), function (e) {
            bookingDetails.bookingTime = $(this).find('select[id="bk_time"]').val();
        });

        $('body').on('click', '.add-booking-details', function() {
            bookingDetails.selected_user = $('#selected_user').val();
            bookingDetails.bookingDate = $('#booking_date').val();

            $.easyAjax({
                url: '{{ route('front.addBookingDetails') }}',
                type: 'POST',
                blockUI: false,
                data: bookingDetails,
                disableButton: true,
                buttonSelector: "#nextBtn",
                success: function (response) {
                    if (response.status == 'success') {
                        window.location.href = '{{ route('front.checkoutPage') }}'
                    }
                }, error: function (err) {
                    var errors = err.responseJSON.errors;
                    for (var error in errors) {
                        $.showToastr(errors[error][0], 'error')
                    }
                }
            });
        });


        $('body').on('click', '.check-user-availability', function() {
            let date = $(this).data('date');
	        let radioId = $(this).data('radio-id');
	        let time = $(this).data('time');

            $('#select_user_div').hide();
            $('#no_emp_avl_msg').hide();
            $('#show_emp_name_div').hide();

            $.easyAjax({
                url: '{{ route('front.checkUserAvailability') }}',
                type: 'POST',
                blockUI: false,
                container: 'section.section',
                data: {date:date, _token: "{{ csrf_token() }}" },
                success: function (response) {
                    if (response.continue_booking == 'no') {
                        $('#no_emp_avl_msg').show();
                        $('#timeSpan').html(time);
                        $('#radio'+radioID).prop("checked", false);
                    } else{
                        $('#no_emp_avl_msg').hide();
                        if(typeof response.select_user !== 'undefined'){
                            $('#select_user_div').show();
                            $('#select_user').html(response.select_user);
                        }
                    }
                }
            });
        });

    </script>
@endpush
