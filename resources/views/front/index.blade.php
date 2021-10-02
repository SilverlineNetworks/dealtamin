@extends('layouts.front')

@push('styles')
    <style>
        .featured_deal_imgBox {
            height: 236px;
            overflow: hidden;
        }
        .rupee {
            font-size: 26px !important;
            font-weight: 500;
            line-height: 0 !important;
            color: #fff !important;
        }
    </style>
@endpush

@section('content')

    <!-- SLIDER START -->
        @if (array_search('Slider Section', array_column($sections, 'name')) !== false && $sliderContents->count() > 0)
            <section class="position-relative bannerSection">
                <div class="container-fluid">
                    <div class="row">
                        <div class="owl-carousel owl-theme" id="banner_slider">
                            @foreach ($sliderContents as $sliderContent)
                            <div class="item">
                                <div class="banner_img1" style="background-image: url({{ $sliderContent->image_url }});">
                                    @if ($sliderContent->content != '' || $sliderContent->action_button != '')
                                    <div class="container">
                                        <div class="slide-top-pd">
                                            <div class="item-inner itemBox-{{ $sliderContent->content_alignment }} text-center">
                                                {!! $sliderContent->content !!}
                                                @if ($sliderContent->open_tab == 'current')
                                                <a href="{{ $sliderContent->action_button }}" class="login draw-border btn">{{ ucwords($sliderContent->action_button) }} <i class="zmdi zmdi-long-arrow-right"></i></a>
                                                @endif
    
                                                @if ($sliderContent->open_tab == 'new')
                                                <a href="/{{ $sliderContent->action_button }}" target="_blank" class="login draw-border btn"> {{ ucwords($sliderContent->action_button) }} <i class="zmdi zmdi-long-arrow-right"></i></a>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    @endif
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </section>
        @endif
    <!-- SLIDER END -->


        <section class="about-style-two">
            <div class="container">
                <div class="row align-items-center clearfix">
                    <div class="col-lg-6 col-md-12 col-sm-12 content-column">
                        <div class="content_block_1">
                            <div class="content-box mr-50">
                                <div class="sec-title">
                                    <p>About {{ $settings->company_name }}</p>
            	                    <h2>Who We Are</h2>
                                </div>
                                <div class="text">
                                    <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industrys standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged.</p>
                                </div>
                                <ul class="list-style-one clearfix">
                                    <li>Search Best Online Professional</li>
                                    <li>View Clinic Professional Profile</li>
                                    <li>Get Instant Clinic Appoinment</li>
                                </ul>
                                <div class="btn-box"><a href="{{ url('/about-us') }}" class="theme-btn-one">About Us<i class="icon-Arrow-Right"></i></a></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-12 col-sm-12 image-column">
                        <img src="assets/img/about-1.jpg" alt="">
                    </div>
                </div>
            </div>
        </section>

        <!-- CHOOSE YOUR CATEGORY START -->
        @if (array_search('Category Section', array_column($sections, 'name')) !== false)
            <section class="categorySection" id="categorySection">
                <div class="container">
                    <div class="sec-title light centred">
                        <p>@lang('front.chooseYourCategoryHead')</p>
                        <h2>@lang('front.chooseYourCategory')</h2>
                    </div>
                    <div class="row">
                    </div>
                </div>
            </section>
        @endif
        <!-- CHOOSE YOUR CATEGORY END -->

        <section class="feature-section centred">
            <div class="pattern-layer">
                <div class="pattern-1" style="background-image: url(assets/img/shape/shape-13.png);"></div>
                <div class="pattern-2" style="background-image: url(assets/img/shape/shape-14.png);"></div>
            </div>
            <div class="container">
                <div class="row clearfix">
                    <div class="col-lg-3 col-md-6 col-sm-12 feature-block">
                        <div class="feature-block-one wow fadeInUp animated animated" data-wow-delay="00ms" data-wow-duration="1500ms">
                            <div class="inner-box">
                                <div class="pattern">
                                    <div class="pattern-1" style="background-image: url(assets/img/shape/shape-5.png);"></div>
                                    <div class="pattern-2" style="background-image: url(assets/img/shape/shape-9.png);"></div>
                                </div>
                                <figure class="icon-box"><img src="assets/img/icons/icon-1.png" alt=""></figure>
                                <p>Bookings</p>
                                <h3>Free Cancellation</h3>
                                <div class="btn-box"><a href="" class="theme-btn-one">Book Now<i class="icon-Arrow-Right"></i></a></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-sm-12 feature-block">
                        <div class="feature-block-one wow fadeInUp animated animated" data-wow-delay="200ms" data-wow-duration="1500ms">
                            <div class="inner-box">
                                <div class="pattern">
                                    <div class="pattern-1" style="background-image: url(assets/img/shape/shape-6.png);"></div>
                                    <div class="pattern-2" style="background-image: url(assets/img/shape/shape-10.png);"></div>
                                </div>
                                <figure class="icon-box"><img src="assets/img/icons/icon-2.png" alt=""></figure>
                                <p>Safeguard Your Payments</p>
                                <h3>Secure Payment</h3>
                                <div class="btn-box"><a href="" class="theme-btn-one">Read More<i class="icon-Arrow-Right"></i></a></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-sm-12 feature-block">
                        <div class="feature-block-one wow fadeInUp animated animated" data-wow-delay="400ms" data-wow-duration="1500ms">
                            <div class="inner-box">
                                <div class="pattern">
                                    <div class="pattern-1" style="background-image: url(assets/img/shape/shape-7.png);"></div>
                                    <div class="pattern-2" style="background-image: url(assets/img/shape/shape-11.png);"></div>
                                </div>
                                <figure class="icon-box"><img src="assets/img/icons/icon-3.png" alt=""></figure>
                                <p>The Smart Clinic</p>
                                <h3>Reviews</h3>
                                <div class="btn-box"><a href="" class="theme-btn-one">Book now<i class="icon-Arrow-Right"></i></a></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-sm-12 feature-block">
                        <div class="feature-block-one wow fadeInUp animated animated" data-wow-delay="600ms" data-wow-duration="1500ms">
                            <div class="inner-box">
                                <div class="pattern">
                                    <div class="pattern-1" style="background-image: url(assets/img/shape/shape-8.png);"></div>
                                    <div class="pattern-2" style="background-image: url(assets/img/shape/shape-12.png);"></div>
                                </div>
                                <figure class="icon-box"><img src="assets/img/icons/icon-4.png" alt=""></figure>
                                <p>24/7 Active Support</p>
                                <h3>Help Support</h3>
                                <div class="btn-box"><a href="" class="theme-btn-one">Contact Now<i class="icon-Arrow-Right"></i></a></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- FEATURED DEALS START -->
        @if (array_search('Deal Section', array_column($sections, 'name')) !== false)
            <section class="featuredSection" id="featuredDeals">
                <div class="container">
                    <div class="sec-title">
                        <p>@lang('front.featuredDealsHead')</p>
                        <h2>@lang('front.featuredDeals')</h2>
                    </div>
                    <div class="row">
                        <div class="owl-carousel owl-theme" id="featured_deal_slider">

                        </div>
                    </div>
                    {{-- <div class="row justify-content-center mt-3" id="view_all_deals_btn">
                        <a href="{{ route('front.deals') }}" class="view_all hvr-radial-out">@lang('app.viewAll')</a>
                    </div> --}}
                </div>
            </section>
        @endif
        <!-- FEATURED DEALS END -->

        <section class="process-section bg-color-2">
            <div class="pattern-layer">
                <div class="pattern-1" style="background-image: url(assets/img/shape/shape-17.png);"></div>
                <div class="pattern-2" style="background-image: url(assets/img/shape/shape-18.png);"></div>
                <div class="pattern-3" style="background-image: url(assets/img/shape/shape-19.png);"></div>
            </div>
            <div class="container">
                <div class="sec-title light centred">
                    <p>Process</p>
                    <h2>Appointment Process</h2>
                </div>
                <div class="inner-content">
                    <div class="row clearfix">
                        <div class="col-lg-4 col-md-6 col-sm-12 processing-block">
                            <div class="processing-block-one">
                                <div class="inner-box">
                                    <figure class="icon-box">
                                        <img src="assets/img/icons/icon-5.png" alt="">
                                        <span>01</span>
                                    </figure>
                                    <h3>Search Best Clinics Online</h3>
                                    <p>Lorem ipsum dolor sit amet consectur adipiscing elit.</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6 col-sm-12 processing-block">
                            <div class="processing-block-one">
                                <div class="inner-box">
                                    <figure class="icon-box">
                                        <img src="assets/img/icons/icon-6.png" alt="">
                                        <span>02</span>
                                    </figure>
                                    <h3>View Professional Clinic Profile</h3>
                                    <p>Lorem ipsum dolor sit amet consectur adipiscing elit.</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6 col-sm-12 processing-block">
                            <div class="processing-block-one">
                                <div class="inner-box">
                                    <figure class="icon-box">
                                        <img src="assets/img/icons/icon-7.png" alt="">
                                        <span>03</span>
                                    </figure>
                                    <h3>Get Instant Service Appoinment</h3>
                                    <p>Lorem ipsum dolor sit amet consectur adipiscing elit.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        
        <!-- LATEST COUPONS START -->
        @if (array_search('Coupon Section', array_column($sections, 'name')) !== false && $coupons->count() > 0)
            <!--<section class="couponSection">
                <div class="container">
                    <div class="sec-title">
                        <p>@lang('front.latestCouponsHead')</p>
                        <h2>@lang('front.latestCoupons')</h2>
                    </div>
                    <div class="">
                        <div class="owl-carousel owl-theme" id="latest_coupon_slider">
                            @foreach ($coupons as $coupon)
                                @if ($loop->iteration%6==1 || $loop->first) <div class="item"><div class="row"> @endif
                                <div class="col-lg-4 col-md-6 d-flex mb-4">
                                    <div class="media coupon_box">
                                        <div class="coupon_discount align-self-center">
                                            <h2 class="mb-1">
                                                {{$coupon->title}}
                                            </h2>
                                            <p class="mb-0"><i class="zmdi zmdi-time"></i>
                                                @lang('app.expireOn')
                                                {{  \Carbon\Carbon::parse($coupon->end_date_time)->translatedFormat($settings->date_format) }}
                                            </p>
                                        </div>
                                        <div class="media-body coupon_code_box text-center position-relative">
                                            <h2>
                                                @if (!is_null($coupon->amount) && $coupon->discount_type === 'percentage')
                                                    <span class="rupee">{{$coupon->amount}}%</span>
                                                    <br><span>@lang('app.off')</span>
                                                @elseif(!is_null($coupon->amount) && $coupon->discount_type === 'amount')
                                                    <span class="rupee">{{$settings->currency->currency_symbol}}{{$coupon->amount}}</span>
                                                    <br><span>@lang('app.off')</span>
                                                @endif
                                            </h2>
                                            <a href="javascript:;" id="coupon_one" class="show_latest_coupon_code show-coupon" data-coupon-id="{{$coupon->id}}" data-coupon-title="{{$coupon->title}}" data-coupon-description="{{$coupon->description}}" data-coupon-code="{{$coupon->code}}"> @lang('app.show') @lang('app.code') </a>
                                        </div>
                                    </div>
                                </div>
                                @if ($loop->iteration%6==0 || $loop->last)
                                    </div></div>
                                @endif
                            @endforeach
                        </div>
                    </div>
                </div>
            </section>-->
        @endif
        <!-- LATEST COUPONS END -->

        <!-- SPOTLIGHT START -->
        @if (array_search('Spotlight Section', array_column($sections, 'name')) !== false && $coupons->count() > 0)
            <!--<section class="spotlightSection position-relative" id="spotlightSection">
                <div class="container">
                    <div class="sec-title">
                        <p>@lang('menu.spotlightHead')</p>
                        <h2>@lang('menu.spotlight')</h2>
                    </div>
                    <div class="">
                        <div class="owl-carousel owl-theme" id="spotlight_slider">

                        </div>
                    </div>
                </div>
            </section>-->
        @endif
        <!-- SPOTLIGHT END -->

        <section class="clients-section bg-color-7">
            <div class="pattern-layer">
                <div class="pattern-1" style="background-image: url(assets/img/shape/shape-3.png);"></div>
                <div class="pattern-2" style="background-image: url(assets/img/shape/shape-4.png);"></div>
            </div>
            <div class="auto-container">
                <div class="clients-carousel owl-carousel owl-theme owl-nav-none owl-dots-none">  
                    @foreach ($popularStores as $store)
                    <figure class="clients-logo-box"><a href="{{ route('front.search', ['c' => $store->id, 'term' => $store->company_name]) }}"><img src="{{ 'user-uploads/company-logo/'.$store->logo }}" alt="{{ ucwords($store->company_name) }}"></a></figure>
                    @endforeach
                </div>
            </div>
        </section>
        
@endsection

@push('footer-script')
    <script type="text/javascript">
        $(function () {
            /* this function fetches deals, categories, and spotlight data on page load */
            ajax();
        });
    </script>
@endpush

