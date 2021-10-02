@extends('layouts.master')

@push('head-css')
<link rel="stylesheet" href="{{ asset('assets/css/jquery-ui.min.css') }}">
<style>
    .link-stats {
        cursor: pointer;
    }
</style>
@endpush

@section('content')
<div class="row mb-2">
    @if($user->is_superadmin)
    <div class="col-md-12">
        @php($updateVersionInfo = \Froiden\Envato\Functions\EnvatoUpdate::updateVersionInfo())
        @if(isset($updateVersionInfo['lastVersion']))
        <div class="alert alert-primary col-md-12">
            <div class="row">
                <div class="col-md-10 d-flex align-items-center"><i class="fa fa-gift fa-3x mr-2"></i>
                    @lang('modules.update.newUpdate') <span
                        class="badge badge-success">{{ $updateVersionInfo['lastVersion'] }}</span>
                </div>
                <div class="col-md-2 text-right">
                    <a href="{{ route('superadmin.update.index') }}" class="btn btn-success">@lang('app.update')</a>
                </div>
            </div>
        </div>
        @endif
    </div>
    @endif
    @if (!$user->mobile_verified && $smsSettings->nexmo_status == 'active')
    <div id="verify-mobile-info" class="col-md-12">
        <div class="alert alert-info col-md-12" role="alert">
            <div class="row">
                <div class="col-md-10 d-flex align-items-center">
                    <i class="fa fa-info fa-3x mr-2"></i>
                    @lang('messages.info.verifyAlert')
                </div>
                <div class="col-md-2 d-flex align-items-center justify-content-end">
                    <a href="{{ route('superadmin.profile.index') }}" class="btn btn-warning">
                        @lang('menu.profile')
                    </a>
                </div>
            </div>
        </div>
    </div>
    @endif
    @if (strlen($smsSettings->nexmo_from) > 18)
    <div id="brand-length" class="col-md-12">
        <div class="alert alert-danger col-md-12" role="alert">
            <div class="row">
                <div class="col-md-10 d-flex align-items-center">
                    <i class="fa fa-exclamation-triangle fa-3x mr-2"></i>
                    @lang('messages.info.smsNameAlert')
                </div>
                <div class="col-md-2 d-flex align-items-center justify-content-end">
                    <a href="{{ route('admin.settings.index').'#sms-settings' }}" class="btn btn-info">
                        @lang('menu.settings')
                    </a>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>
<div class="row">
    <div class="col-md-8">
        <div class="row">
            {{-- active companies --}}
            <div class="col-md-4 col-sm-6 col-12">
                <div class="info-box">
                    <span class="info-box-icon bg-info"><i class="nav-icon icon-home"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">@lang('app.totalCompanies')</span>
                        <span class="info-box-number" id="total-companies">{{ $totalCompanies }}</span>
                    </div>
                </div>
            </div>
            {{-- active companies --}}
            {{-- active companies --}}
            <div class="col-md-4 col-sm-6 col-12">
                <div class="info-box">
                    <span class="info-box-icon bg-success"><i class="nav-icon icon-home"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">@lang('modules.dashboard.ActiveCompanies')</span>
                        <span class="info-box-number" id="total-companies">{{ $activeCompanies }}</span>
                    </div>
                </div>
            </div>
            {{-- active companies --}}
            {{-- inactive companies --}}
            <div class="col-md-4 col-sm-6 col-12">
                <div class="info-box">
                    <span class="info-box-icon bg-danger"><i class="nav-icon icon-home"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">@lang('modules.dashboard.InActiveCompanies')</span>
                        <span class="info-box-number" id="total-inactive-companies">{{ $deActiveCompanies }}</span>
                    </div>
                </div>
            </div>
            {{-- inactive companies --}}
            @if($user->is_admin)
            <div class="col-md-4 col-sm-6 col-12">
                <div class="info-box">
                    <span class="info-box-icon bg-dark-gradient"><i class="fa fa-users"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">@lang('modules.dashboard.totalCustomers')</span>
                        <span class="info-box-number" id="total-customers">0</span>
                    </div>
                    <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
            </div>
            <!-- /.col -->
            <div class="col-md-4 col-sm-6 col-12">
                <div class="info-box">
                    <span class="info-box-icon bg-success">{{ $settings->currency->currency_symbol }}</span>
                    <div class="info-box-content">
                        <span class="info-box-text">@lang('modules.dashboard.totalEarning')</span>
                        <span class="info-box-number" id="total-earning">0</span>
                    </div>
                    <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
            </div>
            <!-- /.col -->
            @endif
        </div>
        <div class="row">
            @if($user->is_admin)
            <div class="col-md-12 mb-5">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">@lang('modules.dashboard.recentBookings')</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body table-responsive p-0">
                        <table class="table">
                            @forelse($recentSales as $booking)
                            <tr>
                                <td>
                                    <a href="{{ route('admin.customers.show', $booking->user->id) }}"
                                        data-toggle="tooltip"
                                        data-original-title="{{ ucwords($booking->user->name)  }}"><img
                                            src="{{ $booking->user->user_image_url }}"
                                            class="border img-bordered-sm img-size-50 img-circle"></a>
                                </td>
                                <td>
                                    <a class="text-uppercase"
                                        href="{{ route('admin.customers.show', $booking->user->id) }}">{{ ucwords($booking->user->name)  }}</a><br>
                                    <i class="icon-email"></i> {{ $booking->user->email ?? '--' }}<br>
                                    <i class="icon-mobile"></i>
                                    {{ $booking->user->mobile ? $booking->user->formatted_mobile : '--' }}
                                </td>
                                <td>
                                    <ol>
                                        @foreach($booking->items as $key=>$item)
                                        <li>{{ ucwords(is_null($item->business_service_id) ? $item->product->name : $item->businessService->name) }}
                                            x{{ $item->quantity }}</li>
                                        @endforeach
                                    </ol>
                                </td>
                                <td class="text-muted">
                                    <i class="icon-calendar"></i>
                                    {{ $booking->date_time->format($settings->date_format) }}<br>
                                    <i class="icon-alarm-clock"></i>
                                    {{ $booking->date_time->format($settings->time_format) }}
                                </td>
                                <td>
                                    <span class="text-uppercase small border
                                @if($booking->status == 'completed') border-success text-success @endif
                                @if($booking->status == 'pending') border-warning text-warning @endif
                                @if($booking->status == 'approved') border-info text-info @endif
                                @if($booking->status == 'in progress') border-primary text-primary @endif
                                @if($booking->status == 'canceled') border-danger text-danger @endif
                                badge-pill">@lang('app.'.$booking->status)</span>
                                    @if(($booking->status == 'pending' || $booking->status == 'approved') &&
                                    $booking->date_time->greaterThanOrEqualTo(\Carbon\Carbon::now()))
                                    <br><br><a href="javascript:;" data-booking-id="{{ $booking->id }}"
                                        class="btn btn-rounded btn-outline-dark btn-sm send-reminder"><i
                                            class="fa fa-send"></i> @lang('modules.booking.sendReminder')</a>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td>@lang('messages.noRecordFound')</td>
                            </tr>
                            @endforelse
                        </table>
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
            @endif
        </div>
    </div>
    <div class="col-md-4">
        <div class="row">
            @if ($user->is_admin || $user->is_employee)
            <div class="col-md-12" id="todo-items-list">
            </div>
            @endif
        </div>
    </div>
</div>
@endsection

@push('footer-js')
<script src="{{ asset('assets/js/jquery-ui.min.js') }}"></script>
<script>
    var updated = true;

        function showNewTodoForm() {
            let url = "{{ route('admin.todo-items.create') }}"
            $.ajaxModal('#application-modal', url);
        }

        function initSortable() {
            let updates = {'pending-tasks': false, 'completed-tasks': false};
            let completedFirstPosition = $('#completed-tasks').find('li.draggable').first().data('position');
            let pendingFirstPosition = $('#pending-tasks').find('li.draggable').first().data('position');

            $('#pending-tasks').sortable({
                connectWith: '#completed-tasks',
                cursor: 'move',
                handle: '.handle',
                stop: function (event, ui) {
                    const id = ui.item.data('id');
                    const oldPosition = ui.item.data('position');

                    if (updates['pending-tasks']===true && updates['completed-tasks']===true) {
                        const inverseIndex =  completedFirstPosition > 0 ? completedFirstPosition - ui.item.index() + 1 : 1;
                        const newPosition = inverseIndex;
                        updateTodoItem(id, position={oldPosition, newPosition}, status='completed');
                    } else if(updates['pending-tasks']===true && updates['completed-tasks']===false) {
                        const newPosition = pendingFirstPosition - ui.item.index();
                        updateTodoItem(id, position={oldPosition, newPosition});
                    }

                    //finally, clear out the updates object
                    updates['pending-tasks']=false;
                    updates['completed-tasks']=false;
                },
                update: function (event, ui) {
                    updates[$(this).attr('id')] = true;
                }
            }).disableSelection();

            $('#completed-tasks').sortable({
                connectWith: '#pending-tasks',
                cursor: 'move',
                handle: '.handle',
                stop: function (event, ui) {
                    const id = ui.item.data('id');
                    const oldPosition = ui.item.data('position');

                    if (updates['pending-tasks']===true && updates['completed-tasks']===true) {
                        const inverseIndex =  pendingFirstPosition > 0 ? pendingFirstPosition - ui.item.index() + 1 : 1;
                        const newPosition = inverseIndex;
                        updateTodoItem(id, position={oldPosition, newPosition}, status='pending');
                    } else if(updates['pending-tasks']===false && updates['completed-tasks']===true) {
                        const newPosition = completedFirstPosition - ui.item.index();
                        updateTodoItem(id, position={oldPosition, newPosition});
                    }

                    //finally, clear out the updates object
                    updates['pending-tasks']=false;
                    updates['completed-tasks']=false;
                },
                update: function (event, ui) {
                    updates[$(this).attr('id')] = true;
                }
            }).disableSelection();
        }

        function calculateStats() {
            let startDate = $('#start-date').val();
            let endDate = $('#end-date').val();

            $.easyAjax({
                type: 'GET',
                url: '{{ route("superadmin.dashboard") }}',
                data: {startDate: startDate, endDate: endDate},
                success: function (response) {
                    if (response.status == "success") {
                        $.unblockUI();
                        $('#total-booking').html(response.totalBooking)
                        $('#in-progress-booking').html(response.inProgressBooking)
                        $('#pending-booking').html(response.pendingBooking)
                        $('#approved-booking').html(response.approvedBooking)
                        $('#completed-booking').html(response.completedBooking)
                        $('#canceled-booking').html(response.canceledBooking)
                        $('#offline-booking').html(response.offlineBooking)
                        $('#online-booking').html(response.onlineBooking)
                        $('#total-customers').html(response.totalCustomers)
                        $('#total-earning').html(response.totalEarnings)
                    }
                }
            });
        }

        function updateTodoItem(id, pos, status=null) {
            let data = {
                _token: '{{ csrf_token() }}',
                id: id,
                position: pos,
            };

            if (status) {
                data = {...data, status: status}
            }

            $.easyAjax({
                url: "{{ route('admin.todo-items.updateTodoItem') }}",
                type: 'POST',
                data: data,
                container: '#todo-items-list',
                success: function (response) {
                    $('#todo-items-list').html(response.view);
                    initSortable();
                }
            });
        }

        function showUpdateTodoForm(id) {
            let url = "{{ route('admin.todo-items.edit', ':id') }}"
            url = url.replace(':id', id);

            $.ajaxModal('#application-modal', url);
        }

        function deleteTodoItem(id) {
            swal({
                icon: "warning",
                buttons: ["@lang('app.cancel')", "@lang('app.ok')"],
                dangerMode: true,
                title: "@lang('errors.areYouSure')",
                text: "@lang('errors.deleteWarning')",
            }).then((willDelete) => {
                if (willDelete) {
                    let url = "{{ route('admin.todo-items.destroy', ':id') }}";
                    url = url.replace(':id', id);

                    let data = {
                        _token: '{{ csrf_token() }}',
                        _method: 'DELETE'
                    }

                    $.easyAjax({
                        url,
                        data,
                        type: 'POST',
                        container: '#roleMemberTable',
                        success: function (response) {
                            if (response.status == 'success') {
                                $('#todo-items-list').html(response.view);
                                initSortable();
                            }
                        }
                    })
                }
            });
        }

        $('.datepicker').datetimepicker({
            format: '{{ $date_picker_format }}',
            locale: '{{ $settings->locale }}',
            allowInputToggle: true,
            icons: {
                time: "fa fa-clock-o",
                date: "fa fa-calendar",
                up: "fa fa-arrow-up",
                down: "fa fa-arrow-down",
                previous: 'fa fa-chevron-left',
                next: 'fa fa-chevron-right'
            }
        })

        @if ($user->is_admin || $user->is_employee)
            $('#todo-items-list').html(`{!! $todoItemsView !!}`);
        @endif

    calculateStats();

    initSortable();

        $('body').on('click', '#apply-filter', function () {
            calculateStats();
        });

        $('body').on('click', '.send-reminder', function () {
            let bookingId = $(this).data('booking-id');

            $.easyAjax({
                type: 'POST',
                url: '{{ route("admin.bookings.sendReminder") }}',
                data: {bookingId: bookingId, _token: '{{ csrf_token() }}'}
            });
        });

        $('body').on('click', '#create-todo-item', function () {
            $.easyAjax({
                url: "{{route('admin.todo-items.store')}}",
                container: '#createTodoItem',
                type: "POST",
                data: $('#createTodoItem').serialize(),
                success: function (response) {
                    if(response.status == 'success'){
                        $('#todo-items-list').html(response.view);
                        initSortable();
                        $('#application-modal').modal('hide');
                    }
                }
            })
        });

        $('body').on('click', '#update-todo-item', function () {
            const id = $(this).data('id');
            let url = "{{route('admin.todo-items.update', ':id')}}"
            url = url.replace(':id', id);

            $.easyAjax({
                url: url,
                container: '#editTodoItem',
                type: "POST",
                data: $('#editTodoItem').serialize(),
                success: function (response) {
                    if(response.status == 'success'){
                        $('#todo-items-list').html(response.view);
                        initSortable();

                        $('#application-modal').modal('hide');
                    }
                }
            })
        });

        $('body').on('change', '#todo-items-list input[name="status"]', function () {
            const id = $(this).data('id');
            let status = 'pending';

            if ($(this).is(':checked')) {
                status = 'completed';
            }

            updateTodoItem(id, null, status);
        })
</script>
@endpush