@extends('layouts.master')

@push('head-css')
    <style>
        .dropify-wrapper, .dropify-preview, .dropify-render img {
            background-color: var(--sidebar-bg) !important;
        }
        #carousel-image-gallery .card .img-holder {
            height: 150px;
            overflow: hidden;
        }
        #carousel-image-gallery .card .img-holder img {
            height: 100%;
            object-fit: cover;
            object-position: top;
        }
        .note-group-select-from-files {
            display: none;
        }
        .select2-container .select2-selection--single {
            height: 39px;
        }
        .select2-container--default .select2-selection--single {
            background-color: #fff;
            border: 1px solid #d2d1d1;
            border-radius: 4px;
        }
        .select2-container--default .select2-selection--single .select2-selection__rendered {
            color: #444;
            line-height: 37px;
        }
        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: 26px;
            position: absolute;
            top: 5px;
            right: 1px;
            width: 20px;
        }
        #account-id-display {
            margin-top: 3%;
        }
        #razor-account-id-display {
            margin-top: 3%;
        }
        .switch {
            margin-top: .2em;
        }
        .d-none {
            display: none;
        }
    </style>
@endpush

@section('content')

    <div class="row">
        <div class="col-12 col-md-2 mb-4 mt-3 mb-md-0 mt-md-0">
            <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist"
                 aria-orientation="vertical">
                <a class="nav-link active" href="#general" data-toggle="tab" id="general-tab">@lang('menu.general')</a>
                <a class="nav-link" href="#times" data-toggle="tab">@lang('menu.bookingSettings')</a>
                <a class="nav-link" href="#employee-schedule" data-toggle="tab">@lang('app.employee') @lang('app.schedule') @lang('menu.settings')</a>
                <a class="nav-link" href="#tax" data-toggle="tab">@lang('app.tax') @lang('menu.settings')</a>
                <a class="nav-link" href="#admin-theme" data-toggle="tab">@lang('menu.adminThemeSettings')</a>
                <a class="nav-link module-setting" href="javascript:;">@lang('menu.module') @lang('menu.settings')</a>
                <a class="nav-link" href="#role-permission" data-toggle="tab">@lang('menu.rolesPermissions')</a>
                <a class="nav-link" href="#payment" data-toggle="tab">@lang('app.paymentCredential') @lang('menu.settings')</a>
            </div>
        </div>
        <div class="col-12 col-md-10">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-12">
                            <div class="tab-content">
                                <div class="active tab-pane" id="general">

                                    <form class="form-horizontal ajax-form" id="general-form" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="tax_name"
                                                           class="control-label">@lang('app.company') @lang('app.name')</label>

                                                    <input type="text" class="form-control  form-control-lg"
                                                           id="company_name" name="company_name"
                                                           value="{{ $settings->company_name }}">
                                                </div>

                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="tax_name"
                                                           class="control-label">@lang('app.company') @lang('app.email')</label>
                                                    <input type="text" class="form-control  form-control-lg"
                                                           id="company_email" name="company_email"
                                                           value="{{ $settings->company_email }}">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="tax_name"
                                                           class="control-label">@lang('app.company') @lang('app.phone')</label>
                                                    <input type="text" class="form-control  form-control-lg"
                                                           id="company_phone" name="company_phone"
                                                           value="{{ $settings->company_phone }}">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="exampleInputPassword1">@lang('app.logo')</label>
                                                    <div class="card">
                                                        <div class="card-body">
                                                            <input type="file" id="input-file-now" name="logo"
                                                                   accept=".png,.jpg,.jpeg" class="dropify"
                                                                   data-default-file="{{ $settings->logo_url }}"
                                                            />
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="exampleInputPassword1">@lang('app.address')</label>
                                                    <textarea class="form-control form-control-lg" name="address" id=""
                                                              cols="30" rows="5">{!! $settings->address !!}</textarea>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="date_format" class="control-label">
                                                                @lang('app.date_format')
                                                            </label>

                                                            <select name="date_format" id="date_format"
                                                                    class="form-control form-control-lg select2">
                                                                @foreach($dateFormats as $key => $dateFormat)
                                                                    <option value="{{ $key }}" @if($settings->date_format == $key) selected @endif>{{
                                                                        $key.' ('.$dateObject->format($key).')' }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="time_format" class="control-label">
                                                                @lang('app.time_format')
                                                            </label>

                                                            <select name="time_format" id="time_format"
                                                                    class="form-control form-control-lg select2">
                                                                @foreach($timeFormats as $key => $timeFormat)
                                                                    <option value="{{ $key }}" @if($settings->time_format == $key) selected @endif>{{
                                                                        $key.' ('.$dateObject->format($key).')' }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="tax_name"
                                                           class="control-label">@lang('app.company') @lang('app.website')</label>
                                                    <input type="text" class="form-control form-control-lg" id="website"
                                                           name="website" value="{{ $settings->website }}">
                                                </div>
                                            </div>

                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="tax_name"
                                                           class="control-label">@lang('app.timezone')</label>
                                                    <select name="timezone" id="timezone"
                                                            class="form-control form-control-lg select2">
                                                        @foreach($timezones as $tz)
                                                            <option @if($settings->timezone == $tz) selected @endif>{{
                                                                $tz }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="tax_name"
                                                           class="control-label">@lang('app.currency')</label>
                                                    <select name="currency_id" id="currency_id"
                                                            class="form-control  form-control-lg">
                                                        @foreach($currencies as $currency)
                                                            <option
                                                                @if($currency->id == $settings->currency_id) selected
                                                                @endif
                                                                value="{{ $currency->id }}">{{ $currency->currency_symbol.' ('.$currency->currency_code.')' }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="tax_name"
                                                           class="control-label">@lang('app.language')</label>
                                                    <select name="locale" id="locale"
                                                            class="form-control form-control-lg">
                                                        @forelse($enabledLanguages as $language)
                                                            <option value="{{ $language->language_code }}"
                                                                    @if($settings->locale == $language->language_code) selected @endif >
                                                                {{ $language->language_name }}
                                                            </option>
                                                        @empty
                                                            <option @if($settings->locale == "en") selected
                                                                    @endif value="en">English
                                                            </option>
                                                        @endforelse
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <button id="save-general" type="button" class="btn btn-success"><i
                                                            class="fa fa-check"></i> @lang('app.save')</button>
                                                </div>
                                            </div>
                                        </div>

                                    </form>

                                </div>
                                <!-- /.tab-pane -->

                                <div class="tab-pane" id="times">
                                <form id="booking-times-form" method="post" onkeydown="return event.key != 'Enter';">
                                    @csrf
                                    <div class="row">
                                        <h4 class="col-md-12">@lang('app.booking') @lang('app.option') <hr></h4> <br><br><br>

                                        <div class="col-md-6">
                                            <h5 class="text-primary">@lang('app.multiTaskingEmployee')</h5>
                                            <div class="form-group">
                                                <label class="control-label">@lang('app.assignMultipleEmployeeAtSameTimeSlot')</label>
                                                <br>
                                                <label class="switch">
                                                    <input type="checkbox" name="multi_task_user" id="multi_task_user" value="enabled" @if ( $settings->multi_task_user=='enabled') checked @endif onchange="multiTaskingEmpChanged()">
                                                    <span class="slider round"></span>
                                                </label>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <h5 class="text-primary">@lang('app.limit') @lang('app.booking')</h5>
                                            <div class="form-group">
                                                <label class="control-label">@lang('app.maxBookingPerCustomer')</label>
                                                <br>
                                                <div class="row">
                                                    <div class="col-md-8">
                                                    <input onkeypress="return isNumberKey(event)" class="form-control" type="number" name="no_of_booking_per_customer" min="0" value="{{$settings->booking_per_day}}">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>


                                        <div class="col-md-6">
                                            <h5 class="text-primary">@lang('app.allowEmployeeSelection')</h5>
                                            <div class="form-group">
                                                <label class="control-label">@lang('messages.allowEmployeeSelectionMSG')</label>
                                                <br>
                                                <label class="switch">
                                                    <input value="enabled" type="checkbox" name="employee_selection" @if ( $settings->employee_selection=='enabled') checked @endif>
                                                    <span class="slider round"></span>
                                                </label>
                                            </div>
                                        </div>


                                        <div class="col-md-6">
                                            <h5 class="text-primary">@lang('app.disableSlotDurationAsPerServiceDuration')</h5>
                                            <div class="form-group">
                                                <label class="control-label">@lang('app.disableSlotDurationMSG')</label>
                                                <br>
                                                <label class="switch">
                                                    <input @if ( $settings->disable_slot=='enabled') checked @endif value="enabled" type="checkbox" name="disable_slot" id="disable_slot" onchange="disableSlotChanged()">
                                                    <span class="slider round"></span>
                                                </label>

                                                <div class="row @if($settings->disable_slot=='disabled' || $settings->disable_slot=='') d-none @endif" id="div_disable_slot">
                                                    <br>
                                                    <div class="col-md-8">
                                                    <label class="radio-inline pl-lg-2"><input type="radio" @if($settings->booking_time_type == 'sum') checked @endif
                                                        value="sum" name="booking_time_type" class="booking_time_type"> @lang('app.sum')</label>
                                                    <label class="radio-inline pl-lg-2"><input type="radio"
                                                        @if($settings->booking_time_type == 'avg') checked @endif
                                                        value="avg" name="booking_time_type" class="booking_time_type"> @lang('app.average')</label>
                                                    <label class="radio-inline pl-lg-2"><input type="radio"
                                                        @if($settings->booking_time_type == 'max') checked @endif
                                                        value="max" name="booking_time_type" class="booking_time_type"> @lang('app.maximum')</label>
                                                    <label class="radio-inline pl-lg-2"><input type="radio"
                                                        @if($settings->booking_time_type == 'min') checked @endif
                                                        value="min" name="booking_time_type" class="booking_time_type"> @lang('app.minimum')</label>
                                                    </div>
                                                    <div class="col-12 alert alert-info" role="alert" id="info-msg">

                                                        @if($settings->booking_time_type == 'sum') @lang('messages.sumOfServiceTime').
                                                        @endif
                                                        @if($settings->booking_time_type == 'max') @lang('messages.MaxServiceTime').
                                                        @endif
                                                        @if($settings->booking_time_type == 'min') @lang('messages.MinServiceTime').
                                                        @endif
                                                        @if($settings->booking_time_type == 'avg')@lang('messages.AvgOfServiceTime').form-control-sm
                                                        @endif


                                                    </div>
                                                    <div class="col-12 alert alert-warning" role="alert">
                                                        @lang('messages.disablePaymentsFromFront').
                                                    </div>
                                                </div>
                                            </div>
                                        </div>


                                        <div class="col-md-12">
                                            <button type="button" class="btn btn-success" id="save-booking-times-field"><i
                                                class="fa fa-check"></i>@lang('app.save')</button>
                                        </div>

                                    </div>
                                    <hr><br>

                                    <div class="row">
                                        <div class="col-md">
                                            <h4>@lang('app.booking') @lang('app.schedule')</h4><br>
                                            <div class="table-responsive">
                                                <table class="table table-condensed">
                                                    <tr>
                                                        <th>#</th>
                                                        <th>@lang('app.day')</th>
                                                        <th>@lang('modules.settings.openTime')</th>
                                                        <th>@lang('modules.settings.closeTime')</th>
                                                        <th>@lang('modules.settings.allowBooking')?</th>
                                                        <th>@lang('app.action')</th>
                                                    </tr>
                                                    @foreach($bookingTimes as $key=>$bookingTime)
                                                        <tr>
                                                            <td>{{ $key+1 }}</td>
                                                            <td>@lang('app.'.$bookingTime->day)</td>
                                                            <td>{{ $bookingTime->start_time }}</td>
                                                            <td>{{ $bookingTime->end_time }}</td>
                                                            <td>
                                                                <label class="switch">
                                                                    <input type="checkbox" class="time-status"
                                                                        data-row-id="{{ $bookingTime->id }}"
                                                                        @if($bookingTime->status == 'enabled') checked @endif
                                                                    >
                                                                    <span class="slider round"></span>
                                                                </label>
                                                            </td>
                                                            <td>
                                                                <a href="javascript:;" data-row-id="{{ $bookingTime->id }}"
                                                                class="btn btn-primary btn-rounded btn-sm edit-row"><i
                                                                        class="icon-pencil"></i> @lang('app.edit')</a>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                                <!-- /.tab-pane -->

                                <div class="tab-pane" id="employee-schedule">
                                    @include('admin.employee-schedule.index')
                                </div>
                                <!-- /.tab-pane -->

                                <div class="tab-pane" id="tax">
                                    <form class="form-horizontal ajax-form" id="tax-form" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="tax_name"
                                                        class="control-label">@lang('app.tax') @lang('app.name')</label>

                                                    <input type="text" class="form-control form-control-lg"
                                                        id="tax_name" name="tax_name"
                                                        value="{{ $tax->tax_name }}">
                                                </div>

                                                <div class="form-group">
                                                    <label for="percent"
                                                        class="control-label">@lang('app.percent')</label>

                                                    <input type="number" min="0" step="0.01" value="{{ $tax->percent }}"
                                                        class="form-control form-control-lg" id="percent"
                                                        name="percent">
                                                </div>
                                                <div class="form-group">
                                                    <label for="percent"
                                                        class="control-label">@lang('app.status')</label>

                                                    <select name="status" id="status"
                                                            class="form-control form-control-lg">
                                                        <option
                                                            @if($tax->status == 'active') selected @endif
                                                        value="active">@lang('app.active')</option>
                                                        <option
                                                            @if($tax->status == 'inactive') selected @endif
                                                        value="inactive">@lang('app.inactive')</option>
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <button id="save-tax" type="button" class="btn btn-success"><i
                                                            class="fa fa-check"></i> @lang('app.save')</button>
                                                </div>

                                            </div>

                                        </div>

                                    </form>
                                </div>
                                <!-- /.tab-pane -->

                                <div class="tab-pane" id="admin-theme">
                                    <h4>@lang('menu.adminThemeSettings')</h4>
                                    <section class="mt-3 mb-3">
                                        <form class="form-horizontal ajax-form" id="theme-form" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <div class="row">
                                                <h6 class="col-md-12">@lang('modules.theme.subheadings.colorPallette')</h6>
                                                <div class="col-md-2 ">
                                                    <div class="form-group">
                                                        <label>@lang('modules.theme.primaryColor')</label>
                                                        <input type="text" class="form-control color-picker"
                                                               name="primary_color"
                                                               value="{{ $adminThemeSetting->primary_color }}">
                                                        <div
                                                            style="background-color: {{ $adminThemeSetting->primary_color }}"
                                                            class=" border border-light">&nbsp;
                                                        </div>
                                                    </div>

                                                </div>

                                                <div class="col-md-2 ">
                                                    <div class="form-group">
                                                        <label>@lang('modules.theme.secondaryColor')</label>
                                                        <input type="text" class="form-control color-picker"
                                                               name="secondary_color"
                                                               value="{{ $adminThemeSetting->secondary_color }}">
                                                        <div
                                                            style="background-color: {{ $adminThemeSetting->secondary_color }}"
                                                            class=" border border-light">&nbsp;
                                                        </div>
                                                    </div>

                                                </div>

                                                <div class="col-md-3 ">
                                                    <div class="form-group">
                                                        <label>@lang('modules.theme.sidebarBgColor')</label>
                                                        <input type="text" class="form-control color-picker"
                                                               name="sidebar_bg_color"
                                                               value="{{ $adminThemeSetting->sidebar_bg_color }}">
                                                        <div
                                                            style="background-color: {{ $adminThemeSetting->sidebar_bg_color }}"
                                                            class=" border border-1">&nbsp;
                                                        </div>
                                                    </div>

                                                </div>

                                                <div class="col-md-2 ">
                                                    <div class="form-group">
                                                        <label>@lang('modules.theme.sidebarTextColor')</label>
                                                        <input type="text" class="form-control color-picker"
                                                               name="sidebar_text_color"
                                                               value="{{ $adminThemeSetting->sidebar_text_color }}">
                                                        <div
                                                            style="background-color: {{ $adminThemeSetting->sidebar_text_color }}"
                                                            class="border border-light">&nbsp;
                                                        </div>
                                                    </div>

                                                </div>

                                                <div class="col-md-2 ">
                                                    <div class="form-group">
                                                        <label>@lang('modules.theme.topbarTextColor')</label>
                                                        <input type="text" class="form-control color-picker"
                                                               name="topbar_text_color"
                                                               value="{{ $adminThemeSetting->topbar_text_color }}">
                                                        <div
                                                            style="background-color: {{ $adminThemeSetting->topbar_text_color }}"
                                                            class="border border-1">&nbsp;
                                                        </div>
                                                    </div>
                                                </div>
                                                <!--/span-->
                                            </div>

                                            <div class="row mb-3">
                                                <h6 class="col-md-12">@lang('modules.theme.subheadings.customCss')</h6>

                                                <div class="col-md-12">
                                                    <div id="admin-custom-css">@if(!$adminThemeSetting->custom_css)@lang('modules.theme.defaultCssMessage')@else{!! $adminThemeSetting->custom_css !!}@endif</div>
                                                </div>

                                                <input id="admin-custom-input" type="hidden" name="admin_custom_css">
                                            </div>

                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <button id="save-theme" type="button" class="btn btn-success"><i
                                                            class="fa fa-check"></i> @lang('app.save')</button>
                                                </div>
                                            </div>
                                        </form>
                                    </section>
                                </div>
                                <!-- /.tab-pane -->

                                <div class="tab-pane" id="role-permission">
                                    @include('admin.role-permission.index')
                                </div>
                                <!-- /.tab-pane -->

                                <div class="tab-pane" id="payment">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <h5 class="text-info">@lang('app.stripe')</h5>
                                            @if (!$stripePaymentSetting && $paymentCredential->stripe_status == 'active')
                                                <button id="stripe-get-started" type="button" class="btn btn-success" title="@lang('modules.paymentCredential.connectionDescription')">
                                                    <i class="fa fa-play"></i> @lang('modules.paymentCredential.getStarted')
                                                </button>
                                            @else
                                                <button id="stripe-get-started" type="button" class="btn btn-success" title="@lang('modules.paymentCredential.connectionsDescription')" disabled>&nbsp;&nbsp;&nbsp;@lang('app.stripe')&nbsp;&nbsp;&nbsp;</button>
                                            @endif
                                            <div id="account-id-display" class="form-group @if(!$stripePaymentSetting) d-none @endif">
                                                <h5 class="text-default">@lang('app.yourAccountId'): <span>{{ $stripePaymentSetting->account_id ?? ''}}</span></h5>
                                            </div>
                                        </div>

                                        <div class="col-md-3">
                                            <h5 class="text-info">@lang('app.status')</h5>
                                            <div class="form-group">
                                                <span class="p-1 label label-info">{{ $stripePaymentSetting && $stripePaymentSetting->connection_status === 'connected' ? __('app.connected') : __('app.notConnected') }}</span>&nbsp;
                                            </div>
                                        </div>

                                    </div>
                                    <br>
                                    <div id="stripe-verification" class="{{ $stripePaymentSetting && $stripePaymentSetting->connection_status === 'not_connected' ? '' : 'd-none' }} row">
                                        <div class="col-md-12">
                                            <div class="d-flex">
                                                <h5 class="text-default mr-3">
                                                    @lang('app.verificationLink'):
                                                </h5>
                                                <a class="mr-3" href= "{{ $stripePaymentSetting->link ?? '' }}" target="_blank">
                                                    {{ $stripePaymentSetting->link ?? '' }}
                                                </a>
                                                @if ($stripePaymentSetting && $stripePaymentSetting->link_expire_at->lessThanOrEqualTo(\Carbon\carbon::now()))
                                                <button class="btn btn-info btn-sm" type="submit" value="Refresh" id="refreshLink" name="refreshLink"> <i class="fa fa-refresh" aria-hidden="true"></i></button>
                                                @endif
                                            </div>
                                            <div id="linkExpireNote" class="form-text text-muted">
                                                @lang('app.linkExpireNote'):
                                                <span>
                                                    {{ $stripePaymentSetting ? $stripePaymentSetting->link_expire_at->diffForHumans() : '' }}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <h5 class="text-info">@lang('app.razorpay')</h5>
                                            @if (!$razoypayPaymentSetting && $paymentCredential->razorpay_status == 'active')
                                                <button id="razorpay-get-started" type="button" class="btn btn-success" title="@lang('modules.paymentCredential.connectionDescription')">
                                                    <i class="fa fa-play"></i> @lang('modules.paymentCredential.getStarted')
                                                </button>
                                            @else
                                                <button id="razorpay-get-started" type="button" class="btn btn-success" title="@lang('modules.paymentCredential.connectionsDescription')" disabled>@lang('app.razorpay')</button>
                                            @endif
                                            <div id="razor-account-id-display" class="form-group @if(!$razoypayPaymentSetting) d-none @endif">
                                                <h5 class="text-default">@lang('app.yourAccountId'): <span>{{ $razoypayPaymentSetting->account_id ?? ''}}</span></h5>
                                            </div>
                                        </div>
                                        <div id="razor-status" class="col-md-3">
                                            <h5 class="text-info">@lang('app.status')</h5>
                                            <div class="form-group">
                                                <span class="p-1 label label-info">{{ $razoypayPaymentSetting && $razoypayPaymentSetting->connection_status === 'connected' ? __('app.connected') : __('app.notConnected') }}</span>&nbsp;
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- /.tab-pane -->
                            </div>
                        </div>
                    </div>
                    <!-- /.tab-content -->
                </div><!-- /.card-body -->
            </div>
            <!-- /.nav-tabs-custom -->
        </div>
    </div>
@endsection

@push('footer-js')
    <script src="{{ asset('/bootstrap-colorpicker/dist/js/bootstrap-colorpicker.min.js') }}"></script>
    <script src="{{ asset('assets/ace/ace.js') }}" type="text/javascript" charset="utf-8"></script>
    <script>
        $(function () {
            $('.wrong-currency-message').hide();

            $('body').on('click', '#v-pills-tab a', function (e) {
                e.preventDefault();
                $(this).tab('show');
                $("html, body").scrollTop(0);
            });

            // store the currently selected tab in the hash value
            $('a[data-toggle="tab"]').on("shown.bs.tab", function (e) {
                var id = $(e.target).attr("href").substr(1);
                window.location.hash = id;
            });

            // on load of the page: switch to the currently selected tab
            var hash = window.location.hash;
            $('#v-pills-tab a[href="' + hash + '"]').tab('show');
        });
        var adminCssEditor = ace.edit('admin-custom-css', {
            mode: 'ace/mode/css',
            theme: 'ace/theme/twilight'
        });

        function checkCurrencyCode(currency_code) {
            if ( currency_code === 'INR') {
                return true;
            }
            else {
                return false;
            }
        }

         // employee-schedule table
         employeeScheduleTable = $('#employeeScheduleTable').dataTable({
                responsive: true,
                processing: true,
                serverSide: true,
                ajax: '{!! route('admin.employee-schedule.index') !!}',

                "fnDrawCallback": function( oSettings ) {
                    $("body").tooltip({
                        selector: '[data-toggle="tooltip"]'
                    });
                },
                order: [[1, 'ASC']],
                columns: [
                    { data: 'DT_RowIndex'},
                    { data: 'name', name: 'name' },
                    { data: 'action', name: 'action', width: '20%' }
                ]
            });
            new $.fn.dataTable.FixedHeader( employeeScheduleTable );


            $('body').on('click', '.view-employee-detail', function () {
                var id = $(this).data('row-id');
                var url = '{{ route('admin.employee-schedule.show', ':id')}}';
                url = url.replace(':id', id);

                $('#modelHeading').html('@lang('app.view') @lang('app.schedule')');
                $.ajaxModal('#application-modal', url);
            });

        $('body').on('click', '.edit-row', function () {
            var id = $(this).data('row-id');
            var url = '{{ route('admin.booking-times.edit', ':id')}}';
            url = url.replace(':id', id);

            $('#modelHeading').html('@lang('app.edit') @lang('menu.bookingTimes')');
            $.ajaxModal('#application-modal', url);
        });

        $('.dropify').dropify({
            messages: {
                default: '@lang("app.dragDrop")',
                replace: '@lang("app.dragDropReplace")',
                remove: '@lang("app.remove")',
                error: '@lang('app.largeFile')'
            }
        });

        $('.color-picker').colorpicker({
            format: 'hex'
        }).on('change', function (e) {
            $(this).siblings('div').css('background-color', e.value)
        });

        $('.time-status').change(function () {
            var id = $(this).data('row-id');
            var url = "{{route('admin.booking-times.update', ':id')}}";
            url = url.replace(':id', id);

            if ($(this).is(':checked')) {
                var status = 'enabled';
            } else {
                var status = 'disabled';
            }

            $.easyAjax({
                url: url,
                type: "POST",
                data: {'_method': 'PUT', '_token': "{{ csrf_token() }}", 'status': status}
            })
        });

        $('.offline-payment').change(function () {
            if ($(this).is(':checked')) {
                $('#offlinePayment').val(1);
            } else {
                $('#offlinePayment').val(0);
            }
        });

        function toggle(elementBox) {
            $(elementBox).toggleClass('d-none');
        }

        function toggleRazorPay(elementBox) {
            var elBox = $(elementBox);
            if (checkCurrencyCode('{{ $settings->currency->currency_code }}')) {
                elBox.slideToggle();
                $('.wrong-currency-message').fadeOut();
            }
            else {
                $('.wrong-currency-message').fadeIn();
                $('#razorpay_status').prop('checked', false);
            }
        }

        $('body').on('click', '#save-general', function () {
            $.easyAjax({
                url: '{{route('admin.settings.update', $settings->id)}}',
                container: '#general-form',
                type: "POST",
                file: true
            })
        });

        $('body').on('click', '#save-tax', function () {
            $.easyAjax({
                url: '{{route('admin.tax-settings.update', $tax->id)}}',
                container: '#tax-form',
                type: "POST",
                data: $('#tax-form').serialize()
            })
        });

        $('body').on('click', '#stripe-get-started', function() {
            $.easyAjax({
                url: "{{ route('front.createAccountLink') }}",
                type: 'GET',
                success: function (response) {
                    if (response.status === 'success') {
                        $('#stripe-get-started').addClass('d-none')
                        $('#account-id-display').removeClass('d-none')
                        $('#account-id-display').find('span').html(response.details.account_id)

                        $('#stripe-verification').removeClass('d-none')
                        $('#stripe-verification').find('a').html(response.details.link).attr('href', response.details.link)
                        $('#stripe-verification').find('span').html(response.link_expire_at)
                    }
                }
            })
        })

        $('body').on('click', '#refreshLink', function () {
            $.easyAjax({
                url: '{{route('admin.refreshLink', $stripePaymentSetting->id ?? '')}}',
                type: "GET",
                success: function (response) {
                    if (response.status == 'success') {
                        location.reload();
                    }
                }
            })
        });

        $('body').on('click', '#razorpay-get-started', function() {
            $.ajaxModal('#application-lg-modal', "{{route('admin.credential.accountLinkForm')}}")
        })

        $('body').on('click', '#save-theme', function () {
            $('#admin-custom-input').val(adminCssEditor.getValue());
            $.easyAjax({
                url: '{{route('admin.theme-settings.update', $adminThemeSetting->id)}}',
                container: '#theme-form',
                type: "POST",
                data: $('#theme-form').serialize(),
                success: function (response) {
                    if (response.status == 'success') {
                        location.reload();
                    }
                }
            })
        });

        $('body').on('click', '#save-booking-times-field', function () {
            $.easyAjax({
                url: '{{route('admin.save-booking-times-field')}}',
                container: '#booking-times-form',
                type: "POST",
                data: $('#booking-times-form').serialize(),
                success: function (response) {
                    if (response.status == 'success') {
                        location.reload();
                    }
                }
            })
        });

        function isNumberKey(evt) {
            var charCode = (evt.which) ? evt.which : evt.keyCode
            if (charCode > 31 && (charCode < 48 || charCode > 57))
            return false;
            return true;
        }

        function disableSlotChanged() {
            if($('#disable_slot').is(":checked")) {
                $("#div_disable_slot").removeClass('d-none');
                $('#multi_task_user').prop("checked", false);
            } else {
                $("#div_disable_slot").addClass('d-none');
            }
        }

        function multiTaskingEmpChanged() {
            if($('#multi_task_user').is(":checked")) {
                $("#div_disable_slot").addClass('d-none');
                $('#disable_slot').prop("checked", false);
            }
        }

        $("body").on('click', '.booking_time_type', function(){
            let duration_type = '';
            if($(this).val()=='sum'){
                duration_type = "@lang('messages.sumOfServiceTime').";
            }
            else if($(this).val()=='avg'){
                duration_type = "@lang('messages.AvgOfServiceTime').";
            }
            else if($(this).val()=='max'){
                duration_type = "@lang('messages.MaxServiceTime').";
            }
            else if($(this).val()=='min'){
                duration_type = "@lang('messages.MinServiceTime').";
            }
            $('#info-msg').html(duration_type+'..!');
        });

        $('body').on('click', '.module-setting', function() {
            var url = "{{ route('admin.moduleSetting') }}";
            window.location.href = url;
        });
    </script>
@endpush
