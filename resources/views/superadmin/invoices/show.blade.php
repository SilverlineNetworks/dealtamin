<div class="tab-pane" id="bookingsInvoices">
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table id="bookingInvoicesTable" class="table w-100">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>@lang('app.company')</th>
                            <th>@lang('app.transactionId')</th>
                            <th>@lang('app.amount')</th>
                            <th>@lang('app.application_fee')</th>
                            <th>@lang('app.method')</th>
                            <th>@lang('app.paid_on')</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="tab-pane active" id="subcriptionInvoices">
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table id="myTable" class="table w-100">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>@lang('app.company')</th>
                        <th>@lang('app.package')</th>
                        <th>@lang('modules.payments.transactionId')</th>
                        <th>@lang('app.amount')</th>
                        <th>@lang('app.date')</th>
                        <th>@lang('modules.billing.nextPaymentDate')</th>
                        <th>@lang('modules.payments.paymentGateway')</th>
                        <th>@lang('app.action')</th>
                    </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>

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

