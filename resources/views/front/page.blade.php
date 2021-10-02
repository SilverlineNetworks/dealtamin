@extends('layouts.front')

@push('styles')
<style>
    .all_deals_section {
        padding: 40px
    }
    .form_wrapper {
        padding: 50px;
        width: 750px;
        border-radius: 15px;
        border: solid 2px #eef1f5;
        background-color: #fff;
        margin-top: 30px;
    }
    .form_wrapper span.form_icon {
        width: 122px;
        height: 122px;
        border-radius: 100%;
        background-color: var(--primary-color);
        position: absolute;
        top: -65px;
        margin: 0 auto;
        left: 0;
        right: 0;
        display: inline-grid;
    }
    .form_wrapper span.form_icon i {
        font-size: 35px;
        color: #fff;
        display: flex;
        justify-content: center;
        align-items: center;
    }
</style>
@endpush

@section('content')

<!-- BREADCRUMB START -->
<section class="breadcrumb_section">
    <div class="container">
        <div class="row">
            <div class="col-lg-7 col-md-5">
                <h1 class="mb-0">{{ $page->title }}</h1>
            </div>
            <div class="col-lg-5 col-md-7">
                <nav>
                    <ol class="breadcrumb mb-0 justify-content-center">
                        <li class="breadcrumb-item"><a href="/">@lang('app.home')</a></li>
                        <li class="breadcrumb-item active"><span>{{ $page->title }}</span></li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</section>
<!-- BREADCRUMB END -->

<!-- ABOUT US -->
@if ($page->id == 1)
    <section class="process-style-two">
        <div class="container">
            <div class="inner-content">
                <div class="arrow" style="background-image: url(assets/img/icons/arrow-1.png);"></div>
                <div class="row clearfix centred">
                    <div class="col-lg-4 col-md-6 col-sm-12 processing-block">
                        <div class="processing-block-two">
                            <div class="inner-box">
                                <figure class="icon-box"><img src="assets/img/icons/icon-9.png" alt=""></figure>
                                <h3>Search Best Online Professional</h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 col-sm-12 processing-block">
                        <div class="processing-block-two">
                            <div class="inner-box">
                                <figure class="icon-box"><img src="assets/img/icons/icon-10.png" alt=""></figure>
                                <h3>View Clinic Professional Profile</h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 col-sm-12 processing-block">
                        <div class="processing-block-two">
                            <div class="inner-box">
                                <figure class="icon-box"><img src="assets/img/icons/icon-11.png" alt=""></figure>
                                <h3>Get Instant Clinic Appoinment</h3>
                            </div>
                        </div>
                    </div>
                </div>
            			<br><br>
            	<div class="row clearfix">
                    <div class="col-lg-12 col-md-12 col-sm-12">						
            			<div class="sec-title">
            				<p>About {{ $settings->company_name }}</p>
            				<h2>{{ $page->title }}</h2>
                        </div>
            			<div class="normal-font txt-justify">{!! $page->content !!}</div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endif
<!-- ABOUT US -->

<!-- CONTACT US -->
@if ($page->id == 2)
<section class="information-section sec-pad centred">
    <div class="pattern-layer">
        <div class="pattern-1" style="background-image: url(assets/img/shape/shape-88.png);"></div>
        <div class="pattern-2" style="background-image: url(assets/img/shape/shape-89.png);"></div>
    </div>
    <div class="container">
        <div class="row clearfix">
            <div class="col-md-4 col-sm-12">
                <div class="col-lg-12 col-md-12 col-sm-12 information-column">
                    <div class="single-information-block wow fadeInUp animated animated" data-wow-delay="00ms" data-wow-duration="1500ms">
                        <div class="inner-box">
                            <div class="pattern" style="background-image: url(assets/img/shape/shape-87.png);"></div>
                            <figure class="icon-box"><img src="assets/img/icons/icon-20.png" alt=""></figure>
                            <h3>Email Address</h3>
                            <p>
                                <a href="mailto:{{ $settings->company_email }}">{{ $settings->company_email }}</a>
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12 col-md-12 col-sm-12 information-column">
                    <div class="single-information-block wow fadeInUp animated animated" data-wow-delay="300ms" data-wow-duration="1500ms">
                        <div class="inner-box">
                            <div class="pattern" style="background-image: url(assets/img/shape/shape-87.png);"></div>
                            <figure class="icon-box"><img src="assets/img/icons/icon-21.png" alt=""></figure>
                            <h3>Phone Number</h3>
                            <p>
                                <a href="tel:{{ $settings->company_phone }}">{{ $settings->company_phone }}</a>
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12 col-md-12 col-sm-12 information-column">
                    <div class="single-information-block wow fadeInUp animated animated" data-wow-delay="600ms" data-wow-duration="1500ms">
                        <div class="inner-box">
                            <div class="pattern" style="background-image: url(assets/img/shape/shape-87.png);"></div>
                            <figure class="icon-box"><img src="assets/img/icons/icon-22.png" alt=""></figure>
                            <h3>Office Address</h3>
                            <p> {{ $settings->address }}</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-8 col-sm-12">    
                <div class="col-lg-12 form_wrapper mx-auto position-relative">
                    <form class="contact-form" id="contact_form" method="post" action="">
                        @csrf
                        <span class="form_icon"><i class="zmdi zmdi-email"></i></span>
                        <div class="row">
                            <div class="form-group col-md-12">
                                <label>@lang('front.name') :</label>
                                <input type="text" name="name" class="form-control" placeholder="Enter Your Name...">
                            </div>
                            <div class="form-group col-md-12">
                                <label>@lang('front.registration.email') :</label>
                                <input type="email" name="email" class="form-control" placeholder="Enter Your Email...">
                                <small id="emailHelp" class="form-text text-muted">@lang('front.emailHelp')</small>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>@lang('front.message') :</label>
                            <textarea name="details" class="form-control" rows="5"
                                    placeholder="Enter Your Message..."></textarea>
                        </div>
                        <div class="form-group col-mb-12 mb-0 text-center">
                            <button type="button" name="submit" class="contactSubmitButton">
                                @lang('app.submit')
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d1815.433198767083!2d54.367782230240195!3d24.490085569768866!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3e5e66673f0fdad3%3A0xc0e9b602db8a17f4!2sHamdan%20Bin%20Mohammed%20St%20-%20Abu%20Dhabi!5e0!3m2!1sen!2sae!4v1604559468806!5m2!1sen!2sae" width="100%" height="450" frameborder="0" style="border:0;" allowfullscreen="" aria-hidden="false" tabindex="0"></iframe>
@endif
<!-- CONTACT US -->

<!-- HOW IT WORKS -->
@if ($page->id == 3)
    <section class="process-style-two">
        <div class="container">
            <div class="inner-content">
                <div class="arrow" style="background-image: url(assets/img/icons/arrow-1.png);"></div>
                <div class="row clearfix centred">
                    <div class="col-lg-4 col-md-6 col-sm-12 processing-block">
                        <div class="processing-block-two">
                            <div class="inner-box">
                                <figure class="icon-box"><img src="assets/img/icons/icon-9.png" alt=""></figure>
                                <h3>Search Best Online Professional</h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 col-sm-12 processing-block">
                        <div class="processing-block-two">
                            <div class="inner-box">
                                <figure class="icon-box"><img src="assets/img/icons/icon-10.png" alt=""></figure>
                                <h3>View Clinic Professional Profile</h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 col-sm-12 processing-block">
                        <div class="processing-block-two">
                            <div class="inner-box">
                                <figure class="icon-box"><img src="assets/img/icons/icon-11.png" alt=""></figure>
                                <h3>Get Instant Clinic Appoinment</h3>
                            </div>
                        </div>
                    </div>
                </div>
            			<br><br>
            	<div class="row clearfix">
                    <div class="col-lg-12 col-md-12 col-sm-12">						
            			<div class="sec-title">
            				<p>About {{ $settings->company_name }}</p>
            				<h2>{{ $page->title }}</h2>
                        </div>
            			<div class="normal-font txt-justify">{!! $page->content !!}</div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endif
<!-- HOW IT WORKS -->

<!-- PRIVACY POLICY AND OTHER PAGES -->
@if ($page->id != 1 && $page->id != 2 && $page->id != 3)
<section class="all_deals_section">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 col-11 form_wrapper mx-auto position-relative">
                <div class="normal-font txt-justify">{!! $page->content !!}</div>
            </div>
        </div>
    </div>
</section>
@endif
<!-- PRIVACY POLICY AND OTHER PAGES -->



@endsection

@push('footer-script')
<script>

    $('body').on('click', '.contactSubmitButton', function() {
         $.easyAjax({
            url: '{{ route('front.contact') }}',
            type: 'POST',
            container: '#contact_form',
            formReset: true,
            data: $('#contact_form').serialize(),
            blockUI: false,
            disableButton: true,
            buttonSelector: ".contactSubmitButton",
        })
    });

    $('body').on('keypress', '#contact_form input,#contact_form textarea', function(e) {
        $(this).siblings('.invalid-feedback').remove();
    })
</script>
@endpush
