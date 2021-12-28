@extends('layouts.front')

@push('styles')
    <link href=" {{ asset('front/css/service_detail.css') }} " rel="stylesheet">
    <style>
        .owl-carousel .owl-dots.disabled, .owl-carousel .owl-nav.disabled {
            display: none !important;
        }
        .form_with_buy_deal input {
            text-align: center;
            border: none;
            border-top: 1px solid #ddd;
            border-bottom: 1px solid #ddd;
            margin: 0px;
            width: 70px;
            height: 39px;
            font-size: 20px;
            font-weight: normal;
            font-stretch: normal;
            font-style: normal;
            letter-spacing: normal;
            color: #707070;
        }
        .sub_services .form_with_buy_deal .value-button {
            width: 33px;
            height: 28px;
        }
        .sub_services .form_with_buy_deal input {
            height: 28px;
            font-size: 15px;
        }
        .sub_services .form_with_buy_deal button:nth-child(1) {
            height: 27px;
            padding:0;
            padding-left: 4px;
            padding-right: 4px;
        }
        .sub_services .form_with_buy_deal button:nth-child(2) {
            height: 27px;
            padding:0;
            padding-left: 4px;
            padding-right: 4px;
        }
        .ravatar {
            width: 40px;
            border-radius: 50%;
            border: 1px solid #fff;
            height: 40px;
        }
    </style>
@endpush

@section('content')

    <!-- BREADCRUMB START -->
    <section class="breadcrumb_section">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-md-5">
                    <h1 class="mb-0"> {{ $service->company->company_name }} </h1>
                </div>
                <div class="col-lg-6 col-md-7 d-none d-lg-block d-md-block">
                    <nav>
                        <ol class="breadcrumb mb-0 justify-content-center">
                            <li class="breadcrumb-item"><a href="/">@lang('app.home')</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('front.services', 'all') }}">@lang('front.allServices')</a></li>
                            <li class="breadcrumb-item active"><span> {{ ucwords($service->name) }} </span></li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </section>
    <!-- BREADCRUMB END -->

    <!-- SERVICE DETAIL START -->
    <section class="deal_detail_section">
        <div class="container">
            <div class="row">
                <div class="col-lg-7 col-md-12">
                    <div class="owl-carousel owl-theme" id="deal_detail_slider">

                        @php $count = 0 @endphp
                        @forelse($service->image ?: [] as $image)
                            <div class="item">
                                <div class="deal_detail_img position-relative">
                                    <img src="{{ asset('user-uploads/service/'.$service->id.'/'.$image) }}" alt="Image" />
                                </div>
                            </div>
                            @php $count++ @endphp
                        @empty
                            <div class="item">
                                <div class="deal_detail_img position-relative">
                                    <img src="{{ asset('front/images/deal_detail/sizzlin.png') }}" alt="Image" />
                                </div>
                            </div>
                            <div class="item">
                                <div class="deal_detail_img position-relative">
                                    <img src="{{ asset('front/images/deal_detail/sizzlin.png') }}" alt="Image" />
                                </div>
                            </div>
                        @endforelse


                    </div>
                </div>
                <div class="col-lg-5 col-md-12 deal_detail_box">
                    <h3 class="mt-lg-1 mt-4">{{ $service->company->company_name }}</h3>
                    <h2>{{ $service->name }}</h2>
                    <div class="deal_detail_contact">
                        <span><i class="zmdi zmdi-time"></i>&nbsp;&nbsp;{{ $service->time }} {{ $service->time_type }}</span>
                        &nbsp;&nbsp;|&nbsp;&nbsp;
                        <a href="tel:{{ $service->company->company_phone }}"><i class="zmdi zmdi-phone"></i>&nbsp;&nbsp;{{ $service->company->company_phone }}</a> &nbsp;&nbsp;|&nbsp;&nbsp;
                        <span><i class="zmdi zmdi-pin"></i>&nbsp;&nbsp;{{ $service->location->name }}</span>
                        <br>
                    </div>
                    <div class="deal_detail_offer_with_price d-flex align-items-center">
                        @if($service->discount > 0)
                            <i>
                                @if($service->discount_type=='percent')
                                    {{$service->discount}}%
                                @else
                                {{ $settings->currency->currency_symbol }}{{$service->discount}}
                                @endif
                            @lang('app.off')</i>
                        @endif
                        <p>{{ $settings->currency->currency_symbol }}{{ $service->net_price }}
                            <span>@if($service->discount > 0){{ $settings->currency->currency_symbol }}{{ $service->price }}@endif</span></p>
                    </div>
                    <div class="deal_detail_expiry_date">
                    </div>
                    <div class="form_with_buy_deal d-lg-flex d-md-flex d-block">
                        <form class="mb-lg-0 mb-md-0 mb-4" style="display:none">
                            <div class="value-button" id="decrease" value="Decrease Value"><i class="zmdi zmdi-minus"></i></div>

                            @php $product = current($reqProduct); @endphp

                            <input type="number" id="number" name="qty" value="{{ sizeof($reqProduct) > 0 ? $product['quantity'] : 1 }}" size="4" title="Quantity" class="input-text qty" data-id="{{ $service->id }}" data-price="{{$service->price}}" autocomplete="none" min="1" />

                            <div class="value-button" id="increase" value="Increase Value"><i class="zmdi zmdi-plus"></i></div>
                        </form>
                        <div class="add @if(sizeof($reqProduct) == 0) d-flex @else d-none @endif w-100">
                            <button class="btn btn-custom added-to-cart ml-lg-3 ml-md-3 ml-0" id="add-item">
                                    @lang('front.addItem')
                            </button>
                        </div>
                        <div class="update @if(sizeof($reqProduct) > 0) d-flex @else d-none @endif w-100">
                            <button class="btn btn-custom update-cart ml-lg-3 ml-md-3 ml-0" id="update-item">
                                    @lang('front.buttons.updateCart')
                            </button>
                            <button class="btn btn-custom ml-3 btn-danger" id="delete-product">
                                    @lang('front.table.deleteProduct')
                            </button>
                        </div>
                    </div>

                    <div style="margin-top:10px;">
                        Additional Options <hr/>
                        <?php
                            /*echo '<pre>';
                            print_r($sub_services);
                            echo '</pre>';*/
                        ?>

                        <?php
                            foreach ($sub_services as $sub_service):
                                $image = '';
                                if (isset($sub_service->image[0])) {
                                    $image = $sub_service->image[0];
                                }
                        ?>
                        <div class="sub_services" style="display:flex;flex-direction:row">
                            <div style="margin-right:20px;">
                                @php if (!empty($image)) { @endphp
                                    <img style="width:120px" src="{{ asset('user-uploads/service/'.$sub_service->id.'/'.$image) }}" alt="Image" />
                                @php } else { @endphp
                                    <img style="width:120px" src="{{ asset('img/no-image.jpg') }}" alt="Image" />
                                @php } @endphp
                            </div>
                            <div style="flex-grow:1">
                                <div style="display:flex; flex-direction:row;justify-content:flex-end">
                                    <div style="flex-grow:1"><b>{{$sub_service->name}}</b></div>
                                    <div class="deal_detail_offer_with_price d-flex align-items-center" style="margin-top:0 !important">
                                        @if($sub_service->discount > 0)
                                            <i>
                                                @if($sub_service->discount_type=='percent')
                                                    {{$sub_service->discount}}%
                                                @else
                                                {{ $settings->currency->currency_symbol }}{{$sub_service->discount}}
                                                @endif
                                            @lang('app.off')</i>
                                        @endif
                                    </div>
                                </div>
                                <div class="deal_detail_offer_with_price d-flex align-items-center" style="margin-top:0 !important">
                                    <p style="font-size:16px;">{{ $settings->currency->currency_symbol }}{{ $sub_service->net_price }}
                                        <span>@if($sub_service->discount > 0){{ $settings->currency->currency_symbol }}{{ $sub_service->price }}@endif</span></p>
                                </div>
                                <div class="form_with_buy_deal d-lg-flex d-md-flex d-block" style="margin-top:10px">
                                    <form class="mb-lg-0 mb-md-0 mb-4" style="display:none">
                                        @php $product = current($reqSubProduct); @endphp

                                        @php
                                            $cart_exist = 0;
                                            if (isset($reqSubProduct[$sub_service->id])) {
                                                $cart_exist = 1;
                                            }
                                        @endphp


                                        <div class="value-button decrease" data-id="{{ $sub_service->id }}" id="decrease_{{$sub_service->id}}" value="Decrease Value"><i class="zmdi zmdi-minus"></i></div>
                                        <input type="number" id="number_{{$sub_service->id}}" name="qty" value="{{ $cart_exist > 0 ? $product['quantity'] : 1 }}" size="4" title="Quantity" class="input-text qty" data-id="{{ $sub_service->id }}" data-price="{{$sub_service->net_price}}" autocomplete="none" min="1" />
                                        <div class="value-button increase" data-id="{{ $sub_service->id }}" id="increase_{{$sub_service->id}}" value="Increase Value"><i class="zmdi zmdi-plus"></i></div>
                                    </form>
                                    <div class="add_{{$sub_service->id}} @if($cart_exist == 0) d-flex @else d-none @endif w-100">
                                        <button class="btn btn-custom added-to-cart_sub ml-lg-3 ml-md-3 ml-0" id="add-item_sub_{{$sub_service->id}}" data-id="{{$sub_service->id}}" data-price="{{$sub_service->net_price}}" data-name="{{$sub_service->name}}">
                                                @lang('front.addItem')
                                        </button>
                                    </div>
                                    <div class="update_{{$sub_service->id}} @if($cart_exist > 0) d-flex @else d-none @endif w-100">
                                        <button class="btn btn-custom update-cart_sub ml-lg-3 ml-md-3 ml-0" id="update-item_{{$sub_service->id}}" data-id="{{$sub_service->id}}" data-price="{{$sub_service->net_price}}" data-name="{{$sub_service->name}}">
                                                @lang('front.buttons.update')
                                        </button>
                                        <button class="btn btn-custom ml-3 btn-danger delete_sub_product" id="delete-product_{{$sub_service->id}}" data-id="{{$sub_service->id}}">
                                                @lang('front.table.remove')
                                        </button>
                                    </div>

                                </div>
                            </div>
                        </div><hr/>
                        <?php endforeach; ?>
                        <div class="cart_nav" style="width: 130px;float: right;">
                        <!--<a class="nav-link align-items-center d-flex" href="{{ route('front.cartPage') }}" style="border-radius:20px;display:none"><i class="zmdi zmdi-ticket-star"></i>Check Out</a>-->
                    </div>
                        <?php /*foreach ($sub_services as $sub_service): ?>
                            <h4 style="margin:0;margin-top:20px;margin-bottom:20px;">{{$sub_service->name}}</h4>
                            <div class="d-lg-flex d-md-flex d-block" >

                                <div class="deal_detail_offer_with_price d-flex align-items-center" style="margin-top:0 !important">
                                    @if($sub_service->discount > 0)
                                        <i>
                                            @if($sub_service->discount_type=='percent')
                                                {{$sub_service->discount}}%
                                            @else
                                            {{ $settings->currency->currency_symbol }}{{$sub_service->discount}}
                                            @endif
                                        @lang('app.off')</i>
                                    @endif
                                    <p>{{ $settings->currency->currency_symbol }}{{ $sub_service->net_price }}
                                        <span>@if($sub_service->discount > 0){{ $settings->currency->currency_symbol }}{{ $sub_service->price }}@endif</span></p>
                                </div>
                            </div>


                            <div class="form_with_buy_deal d-lg-flex d-md-flex d-block" style="margin-top:10px">
                                <form class="mb-lg-0 mb-md-0 mb-4">
                                    @php $product = current($reqSubProduct); @endphp

                                    @php
                                        $cart_exist = 0;
                                        if (isset($reqSubProduct[$sub_service->id])) {
                                            $cart_exist = 1;
                                        }
                                    @endphp


                                    <div class="value-button decrease" data-id="{{ $sub_service->id }}" id="decrease_{{$sub_service->id}}" value="Decrease Value"><i class="zmdi zmdi-minus"></i></div>
                                    <input type="number" id="number_{{$sub_service->id}}" name="qty" value="{{ $cart_exist > 0 ? $product['quantity'] : 1 }}" size="4" title="Quantity" class="input-text qty" data-id="{{ $sub_service->id }}" data-price="{{$sub_service->net_price}}" autocomplete="none" min="1" />
                                    <div class="value-button increase" data-id="{{ $sub_service->id }}" id="increase_{{$sub_service->id}}" value="Increase Value"><i class="zmdi zmdi-plus"></i></div>
                                </form>
                                <div class="add_{{$sub_service->id}} @if($cart_exist == 0) d-flex @else d-none @endif w-100">
                                    <button class="btn btn-custom added-to-cart_sub ml-lg-3 ml-md-3 ml-0" id="add-item_sub_{{$sub_service->id}}" data-id="{{$sub_service->id}}" data-price="{{$sub_service->net_price}}" data-name="{{$sub_service->name}}">
                                            @lang('front.addItem')
                                    </button>
                                </div>
                                <div class="update_{{$sub_service->id}} @if($cart_exist > 0) d-flex @else d-none @endif w-100">
                                    <button class="btn btn-custom update-cart_sub ml-lg-3 ml-md-3 ml-0" id="update-item_{{$sub_service->id}}" data-id="{{$sub_service->id}}" data-price="{{$sub_service->net_price}}" data-name="{{$sub_service->name}}">
                                            @lang('front.buttons.updateCart')
                                    </button>
                                    <button class="btn btn-custom ml-3 btn-danger delete_sub_product" id="delete-product_{{$sub_service->id}}" data-id="{{$sub_service->id}}">
                                            @lang('front.table.deleteProduct')
                                    </button>
                                </div>

                            </div><hr/>
                        <?php endforeach;*/ ?>
                    </div>
                </div>
            </div>
            <div class="row service-page-style">
                <ul class="nav nav-tabs">
                    <li class="active"><a data-toggle="tab" href="#home">Details</a></li>
                    <li><a data-toggle="tab" href="#menu1">Location</a></li>
                    <li><a data-toggle="tab" href="#menu2">Review</a></li>
                    <li><a data-toggle="tab" href="#menu3">Gallery</a></li>
                </ul>
                <div class="tab-content deal_detail_content">
                    <div id="home" class="tab-pane active">
                        {!! $service->description !!}
                        <?php foreach ($sub_services as $sub_service): ?>
                            <div><br/><b>{{$sub_service->name}}</b></div>
                            <div>{!! $sub_service->description !!}</div>
                        <?php endforeach; ?>
                    </div>
                    <div id="menu1" class="tab-pane fade">
                        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d116238.2596900766!2d54.36041775359597!3d24.435320269314744!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3e5e67868171df35%3A0xe891e0f59cb756f7!2sAster%20Clinic%2C%20Khalidiya%2C%20Abu%20Dhabi!5e0!3m2!1sen!2sae!4v1624181601857!5m2!1sen!2sae" width="100%" height="300" style="border:0;display:none"></iframe>
                        <iframe src="https://www.google.com/maps/embed/v1/view?key=AIzaSyB8z669FCD9gRnRPuD81MLdATevU2jFqwY&center={{$service->company->latitude}},{{$service->company->longitude}}&zoom=18&maptype=roadmap" width="100%" height="300" style="border:0;"></iframe>
                    </div>
                    <div id="menu2" class="tab-pane fade">
                        <?php foreach ($reviews as $review): ?>
                        <div style="display:flex;flex-direction:row;">
                            <div style="flex-grow: 1">
                                <div style="display:flex;flex-direction:row;">
                                    <div>
                                        <?php
                                            if (!empty($review->image)) {
                                                ?>
                                                <img src="{{ asset('user-uploads/avatar/'.$review->image) }}" alt="Image" class="ravatar"/>
                                                <?php
                                            }
                                            else {
                                                ?>
                                                <img src="{{ asset('user-uploads/avatar/user.png') }}" alt="Image" class="ravatar"/>
                                                <?php
                                            }
                                        ?>
                                    </div>
                                    <div style="margin-left:20px;font-weight:bold">
                                        {{$review->name}} <br/>
                                        <span style="font-weight: normal;color: #9d9898;font-size: 14px;">{{date('d F Y', strtotime($review->created_at))}}</span>
                                    </div>
                                </div>
                            </div>
                            <div>
                                <ul style="display:flex;flex-direction:row;">
                                <?php
                                $starNumber = $review->ratings;
                                for( $x = 0; $x < 5; $x++ )
                                {
                                    if( floor( $starNumber )-$x >= 1 )
                                    { echo '<li style="list-style: none;color:yellow;font-size:20px; margin-right:3px;"><i class="fa fa-star"></i></li>'; }
                                    elseif( $starNumber-$x > 0 )
                                    { echo '<li style="list-style: none;"><i class="fa fa-star-half-o"></i></li>'; }
                                    else
                                    { echo '<li style="list-style: none;color:#e1e1e1;font-size:20px;margin-right:3px;"><i class="fa fa-star"></i></li>'; }
                                }
                                ?>
                                </ul>
                            </div>
                        </div>
                        <p style="margin-top:20px;margin-bottom:20px;">{{$review->message}}</p><hr/>
                        <?php endforeach;?>
                        <!--<form class="contact-form" id="contact_form" method="post" action="">
                            <div class="row">
                                <div class="form-group col-md-12">
                                    <input type="text" name="name" class="form-control" placeholder="Enter Your Name...">
                                </div>
                            </div>
                            <div class="form-group">
                                <textarea name="details" class="form-control" rows="5" placeholder="Share details of your own experience at this place..."></textarea>
                            </div>
                            <div class="form-group col-mb-12 mb-0">
                                <button type="button" name="submit" class="contactSubmitButton">Submit Review</button>
                            </div>
                        </form>-->
                    </div>
                    <div id="menu3" class="tab-pane fade">
                        @php $count = 0 @endphp
                        @forelse($service->image ?: [] as $image)
                            <img src="{{ asset('user-uploads/service/'.$service->id.'/'.$image) }}" alt="Image" />
                        @php $count++ @endphp
                        @empty
                            <img src="{{ asset('front/images/deal_detail/sizzlin.png') }}" alt="Image" />
                            <img src="{{ asset('front/images/deal_detail/sizzlin.png') }}" alt="Image" />
                        @endforelse

                        <?php
                            foreach ($sub_services as $sub_service):
                                $image = '';
                                if (isset($sub_service->image[0])) {
                                    $image = $sub_service->image[0];
                                }
                        ?>
                        @php if (!empty($image)) { @endphp
                            <img src="{{ asset('user-uploads/service/'.$sub_service->id.'/'.$image) }}" alt="Image" />
                        @php } @endphp

                        <?php
                    endforeach;
                        ?>

                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- SERVICE DETAIL END -->

@endsection

@push('footer-script')
    <script>

        $('document').ready(function() {
            
            let ele = $(this);
            let key = $(this).data('key');

            var url = '{{ route('front.deleteProduct', ':id') }}';
            url = url.replace(':id', 'all');

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

                    }
                }
            })
        });

        $('body').on('click', '#increase', function() {
            var currentValue = $('#number').val();
            $('#number').val(parseInt(currentValue) + 1);
        });

        //Increase Sub SERVICE
        $('body').on('click', '.increase', function() {
            var id = $(this).attr('data-id');
            var currentValue = $('#number_' + id).val();
            $('#number_' + id).val(parseInt(currentValue) + 1);
        });

        $('body').on('click', '#decrease', function() {
            var currentValue = $('#number').val();
            if (currentValue > 1) {
                $('#number').val(parseInt(currentValue) - 1);
            }
        });

        //Decrease Sub SERVICE
        $('body').on('click', '.decrease', function() {
            var id = $(this).attr('data-id');
            var currentValue = $('#number_' + id).val();
            if (currentValue > 1) {
                $('#number_' + id).val(parseInt(currentValue) - 1);
            }
        });

        //Delete sub product
        $('body').on('click', '.delete_sub_product', function() {
            let key = $(this).data('id');

            var url = '{{ route('front.deleteFrontProduct', ':id') }}';
            url = url.replace(':id', key);

            $.easyAjax({
                url: url,
                type: 'POST',
                data: {_token: $("meta[name='csrf-token']").attr('content')},
                redirect: false,
                blockUI: false,
                disableButton: true,
                buttonSelector: "#delete-product",
                success: function (response) {
                    $('.cart-badge').text(response.productsCount);

                    $('.add_' + key).addClass('d-flex');
                    $('.add_' + key).removeClass('d-none');

                    $('.update_'+ key).removeClass('d-flex');
                    $('.update_' + key).addClass('d-none');

                    $('#number_' + key).val(1);
                }
            })
        });

        $('body').on('click', '#delete-product', function() {
            let key = $('input.qty').data('id');

            var url = '{{ route('front.deleteFrontProduct', ':id') }}';
            url = url.replace(':id', 'service'+key);

            $.easyAjax({
                url: url,
                type: 'POST',
                data: {_token: $("meta[name='csrf-token']").attr('content')},
                redirect: false,
                blockUI: false,
                disableButton: true,
                buttonSelector: "#delete-product",
                success: function (response) {
                    $('.cart-badge').text(response.productsCount);

                    $('.add').addClass('d-flex');
                    $('.add').removeClass('d-none');

                    $('.update').removeClass('d-flex');
                    $('.update').addClass('d-none');

                    $('input.qty').val(1);
                }
            })
        });

        $('input.qty').on('blur', function () {
            if ($(this).val() == '' || $(this).val() == 0) {
                $(this).val(1);
            }
        });

        //add addons to cart

        $('body').on('click', '.added-to-cart_sub, .update-cart_sub', function () {
            let element_id = $(this).attr('id');
            let type = 'service';
            let unique_id = $(this).attr('data-id');
            let id = $(this).attr('data-id');
            let price = $(this).attr('data-price');
            let name = $(this).attr('data-name');
            let companyId = '{{ $service->company->id }}';
            let quantity = $('#number_' + unique_id).val();
            var data = {id, type, price, name, companyId, quantity, unique_id, _token: $("meta[name='csrf-token']").attr('content')};

            $.easyAjax({
                url: '{{ route('front.addOrUpdateProduct') }}',
                type: 'POST',
                data: data,
                blockUI: false,
                disableButton: true,
                buttonSelector: "#"+element_id,
                success: function (response) {
                    window.location = '{{ route('front.cartPage') }}';
                    if(response.result=='fail')
                    {
                        swal({
                            title: "@lang('front.buttons.clearCart')?",
                            text: "@lang('messages.front.errors.differentItemFound')",
                            icon: "warning",
                            buttons: true,
                            dangerMode: true,
                        }).then((willDelete) => {
                            if (willDelete)
                            {
                                var url = '{{ route('front.deleteProduct', ':id') }}';
                                url = url.replace(':id', 'all');

                                $.easyAjax({
                                    url: url,
                                    type: 'POST',
                                    data: {_token: $("meta[name='csrf-token']").attr('content')},
                                    redirect: false,
                                    success: function (response) {
                                        if (response.status == 'success') {
                                            $.easyAjax({
                                                url: '{{ route('front.addOrUpdateProduct') }}',
                                                type: 'POST',
                                                data: data,
                                                success: function (response) {
                                                    $('.cart-badge').text(response.productsCount);
                                                }
                                            })
                                        }
                                    }
                                })
                            }
                        });
                    }

                    $('.cart-badge').text(response.productsCount);

                    if (response.productsCount > 0) {
                        $('.add_' + unique_id).removeClass('d-flex');
                        $('.add_' + unique_id).addClass('d-none');

                        $('.update_' + unique_id).addClass('d-flex');
                        $('.update_' + unique_id).removeClass('d-none');
                    }
                }
            })
        });

        // add items to cart
        $('body').on('click', '.added-to-cart, .update-cart', function () {

            let element_id = $(this).attr('id');
            let type = 'service';
            let unique_id = '{{ $service->id }}';
            let id = '{{ $service->id }}';
            let price = '{{ $service->discounted_price }}';
            let name = '{{ $service->name }}';
            let companyId = '{{ $service->company->id }}';
            let quantity = $('#number').val();

            var data = {id, type, price, name, companyId, quantity, unique_id, _token: $("meta[name='csrf-token']").attr('content')};

            $.easyAjax({
                url: '{{ route('front.addOrUpdateProduct') }}',
                type: 'POST',
                data: data,
                blockUI: false,
                disableButton: true,
                buttonSelector: "#"+element_id,
                success: function (response) {
                    window.location = '{{ route('front.cartPage') }}';
                    if(response.result=='fail')
                    {
                        swal({
                            title: "@lang('front.buttons.clearCart')?",
                            text: "@lang('messages.front.errors.differentItemFound')",
                            icon: "warning",
                            buttons: true,
                            dangerMode: true,
                        }).then((willDelete) => {
                            if (willDelete)
                            {
                                var url = '{{ route('front.deleteProduct', ':id') }}';
                                url = url.replace(':id', 'all');

                                $.easyAjax({
                                    url: url,
                                    type: 'POST',
                                    data: {_token: $("meta[name='csrf-token']").attr('content')},
                                    redirect: false,
                                    success: function (response) {
                                        if (response.status == 'success') {
                                            $.easyAjax({
                                                url: '{{ route('front.addOrUpdateProduct') }}',
                                                type: 'POST',
                                                data: data,
                                                success: function (response) {
                                                    $('.cart-badge').text(response.productsCount);
                                                }
                                            })
                                        }
                                    }
                                })
                            }
                        });
                    }

                    $('.cart-badge').text(response.productsCount);

                    if (response.productsCount > 0) {
                        $('.add').removeClass('d-flex');
                        $('.add').addClass('d-none');

                        $('.update').addClass('d-flex');
                        $('.update').removeClass('d-none');
                    }
                }
            })
        });


    </script>
@endpush
