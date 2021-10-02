<style>
    .dropify-wrapper, .dropify-preview, .dropify-render img {
        background-color: var(--sidebar-bg) !important;
    }
    .d-none
    {
        display: none;
    }
    .mt3 {
        margin-top:3%;
    }
</style>

<div class="modal-header">
    <h4>@lang('menu.frontSliderSettings')</h4>
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
</div>
<div class="modal-body">
    <section class="mt-3 mb-3">
        <form class="form-horizontal ajax-form" id="createForm" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-md-12">
                    <!-- text input -->
                    <div class="form-group">
                        <h6 class="col-md-12 text-primary">@lang('app.image')</h6>
                        <div class="card">
                            <div class="card-body">
                                <input type="file" id="image" name="image"
                                    accept=".png,.jpg,.jpeg" class="dropify"
                                    data-min-height="493" data-max-height="495"
                                    data-min-width="1918" ata-max-width="1920"
                                />
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <h6 class="col-md-12 text-primary">@lang('app.haveContent') ?</h6>
                        <div class="form-group">
                            <div class="card">
                                <div class="card-body" id="haveContent-card">
                                    <input type="radio" id="content_yes" name="have_content" value="yes">
                                    <label for="content_yes"><h6 class="">@lang('app.yes')</h6></label>&nbsp;&nbsp;&nbsp;
                                    <input type="radio" id="content_no" name="have_content" value="no" checked>
                                    <label for="content_no"> <h6 class="">@lang('app.no')</h6></label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 slider_contents d-none">
                        <h6 class="col-md-6 text-primary">@lang('app.contentAlignment')</h6>
                        <div class="form-group">
                            <div class="card">
                                <div class="card-body mt3">
                                    <input type="radio" id="contentAlignment" name="content_alignment" value="left" checked>
                                    <label for="contentAlignment"> <h6 class="">@lang('app.left')</h6></label>&nbsp;&nbsp;&nbsp;
                                    <input type="radio" id="contentAlignment1" name="content_alignment" value="right">
                                    <label for="contentAlignment1">  <h6 class="">@lang('app.right')</h6></label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row slider_content_form d-none">

                    <div class="col-md-12">
                        <h6 class="col-md-12 text-primary">@lang('app.page') @lang('app.content')</h6>
                        <div class="form-group">
                            <textarea name="slider_content" id="slider_content" cols="30" class="form-control-lg form-control"
                                rows="4"></textarea>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <h6 class="col-md-6 text-primary">@lang('app.openIn')</h6>
                        <div class="form-group mt3">
                            <div class="card">
                                <div class="card-body">
                                    <input type="radio" id="sameTab" name="tab" value="current" checked>
                                    <label for="sameTab"> <h6 class="">@lang('app.current') @lang('app.tab')</h6></label>&nbsp;&nbsp;&nbsp;
                                    <input type="radio" id="newTab" name="tab" value="new">
                                    <label for="newTab">  <h6 class="">@lang('app.new') @lang('app.tab')</h6></label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <h6 class="col-md-6 text-primary">@lang('app.actionButton')</h6>
                        <div class="form-group mt3">
                            <div class="card">
                                <div class="card-body">
                                    <input type="radio" id="custom_yes" name="actionButton" value="login" checked>
                                    <label for="custom_yes"> <h6 class="">@lang('app.login')</h6></label>&nbsp;&nbsp;&nbsp;
                                    <input type="radio" id="custom_no" name="actionButton" value="custom">
                                    <label for="custom_no">  <h6 class="">@lang('app.daterangepicker.custom')</h6></label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12 customData d-none">
                        <div class="row">
                            <div class="col-6">
                                <h6 class="col-md-6 text-primary">@lang('app.customLabel')</h6>
                                <div class="form-group">
                                    <input type="text" class="form-control form-control-lg" name="custom_label" id="custom_label">
                                </div>
                            </div>

                            <div class="col-6">
                                <h6 class="col-md-6 text-primary">@lang('app.customUrl')</h6>
                                <div class="form-group">
                                    <input type="text" class="form-control form-control-lg" name="url" id="custom_url">
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            <div class="col-md-12">
                <div class="form-group">
                    <button id="save-form" type="button" class="btn btn-success">
                        <i class="fa fa-check"></i> @lang('app.save')</button>
                </div>
            </div>

        </form>
    </section>
</div>


<script>
    $('body').on('click', '#content_yes', function() {
        $('.slider_content_form').removeClass('d-none');
        $('.slider_contents').removeClass('d-none');
    });

    $('body').on('click', '#content_no', function() {
        $('.slider_content_form').addClass('d-none');
        $('.customData').addClass('d-none');
        $('.slider_contents').addClass('d-none');
    });

    $('body').on('click', '#custom_no', function() {
        $('.customData').removeClass('d-none');
    });

    $('body').on('click', '#custom_yes', function() {
        $('.customData').addClass('d-none');
    });

    $('.dropify').dropify({
        messages: {
            default: '@lang("app.dragDrop")',
            replace: '@lang("app.dragDropReplace")',
            remove: '@lang("app.remove")',
            error: '@lang('app.largeFile')',
        }
    });

    $(function () {
        $('#slider_content').summernote({
            dialogsInBody: true,
            height: 200,
            toolbar: [
            ['style', ['bold', 'italic', 'underline', 'clear']],
            ['font', ['strikethrough']],
            ['fontsize', ['fontsize']],
            ['para', ['ul', 'ol', 'paragraph']],
            ["view", ["fullscreen"]]
        ]
        })
    });

    $('body').on('click', '#save-form', function() {
        const form = $('#createForm');
        $.easyAjax({
            url: '{{route('superadmin.front-slider.store')}}',
            container: '#createForm',
            type: "POST",
            file:true,
            redirect: true,
            data: form.serialize(),
            success: function (response) {
                if(response.status == 'success'){
                    $('#application-lg-modal').modal('hide');
                    table._fnDraw();
                }
            }
        })
    });

</script>
