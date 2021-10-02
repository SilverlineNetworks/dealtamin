@extends('layouts.master')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-center justify-content-md-end mb-3">
                        <a href="{{ route('superadmin.locations.create') }}" class="btn btn-rounded btn-primary mb-1"><i class="fa fa-plus"></i> @lang('app.createNew')</a>
                    </div>
                    <div class="table-responsive">
                        <table id="myTable" class="table w-100">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>@lang('app.country')</th>
                                    <th>@lang('app.name')</th>
                                    <th>@lang('app.status')</th>
                                    <th>@lang('app.action')</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('footer-js')
    <script>
        $(document).ready(function() {
            var table = $('#myTable').dataTable({
                responsive: true,
                serverSide: true,

                ajax: '{!! route('superadmin.locations.index') !!}',
                language: languageOptions(),
                "fnDrawCallback": function( oSettings ) {
                    $("body").tooltip({
                        selector: '[data-toggle="tooltip"]'
                    });
                },
                columns: [
                    { data: 'DT_RowIndex'},
                    // { data: 'image', name: 'image' },
                    { data: 'country', name: 'country' },
                    { data: 'name', name: 'name' },
                    { data: 'status', name: 'status' },
                    { data: 'action', name: 'action', width: '20%' }
                ]
            });
            new $.fn.dataTable.FixedHeader( table );

            $('body').on('click', '.delete-row', function() {
                var id = $(this).data('row-id');
                swal({
                    icon: "warning",
                    buttons: ["@lang('app.cancel')", "@lang('app.ok')"],
                    dangerMode: true,
                    title: "@lang('errors.areYouSure')",
                    text: "@lang('errors.locationDeleteWarning')",
                }).then((willDelete) => {
                    if (willDelete) {
                        var url = "{{ route('superadmin.locations.destroy',':id') }}";
                        url = url.replace(':id', id);

                        var token = "{{ csrf_token() }}";

                        $.easyAjax({
                            type: 'POST',
                            url: url,
                            data: {'_token': token, '_method': 'DELETE'},
                            success: function (response) {
                                if (response.status == "success") {
                                    $.unblockUI();
                                    table._fnDraw();
                                }
                            }
                        });
                    }
                });
            });

            $('body').on('change', '.location_status', function () {
                const location_id = $(this).data('location-id');
                const location_status = $(this).val();

                $.easyAjax({
                    url: '{{ route('superadmin.location.changeStatus') }}',
                    type: 'POST',
                    data: { _token: '{{ csrf_token() }}', location_id, location_status },
                    container: '#myTable',
                    success: function (response) {
                        if (response.status === 'success') {
                            table._fnDraw();
                        }
                    }
                })
            });
        });
    </script>
@endpush
