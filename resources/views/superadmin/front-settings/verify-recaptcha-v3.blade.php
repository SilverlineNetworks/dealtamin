<div class="modal-header">
    <h5 class="modal-title">@lang('menu.verifyGoogleRecaptchaV3')</h5>
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
</div>
​
<div class="modal-body">
    <div class="portlet-body" id="portlet-body" data-error="false">
        <div class="alert alert-primary" role="alert"><i class="fa fa-info-circle"></i>
            @lang('pleaseWait')...! @lang('keyHasBeenVerifying').
        </div>
    </div>
</div>
<div class="modal-footer">
    <button class="btn btn-info" data-dismiss="modal" class="border-0 mr-3">@lang('app.cancel')</button>
    <button type="button" class="btn btn-primary g-recaptcha" id="save-method" data-sitekey="{{ $key }}"
        data-callback='saveForm' data-error-callback="errorMsg">
        <i class="fa fa-check" aria-hidden="true"></i>@lang('app.save')
    </button>
</div>
​
<script src="https://www.google.com/recaptcha/api.js"></script>
<script>
    setTimeout(() => {
        if ($('#portlet-body').data('error') !== true) {
            let msg = `<div class="alert alert-success" type="success">
            Key has been verified. Click on save button to save key.
            <i class="fa fa-info-circle"></i></div>`;
            $('#portlet-body').html(msg);
            $('#save-method').show();
        }
    }, 3000);
</script>
