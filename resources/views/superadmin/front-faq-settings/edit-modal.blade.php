<div class="modal-header">
   <h4 class="modal-title">@lang('app.edit') @lang('app.faq.title') </h4>
   <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
</div>
<div class="modal-body">
   <form role="form" id="editForm" class="ajax-form" method="POST">
      @csrf
      @method('PUT')
      <div class="row">
         <div class="col-md-12">
            <div class="form-group">
               <label>@lang('app.language')</label>
               <select name="language" id="lang-status" class="form-control form-control-lg">
               @foreach ($languages as $language)
               <option {{ $faq->language_id == $language->id ? 'selected' : '' }}  value="{{ $language->id }}">{{ $language->language_name }}</option>
               @endforeach
               </select>
            </div>
         </div>
         <div class="col-md-12">
            <!-- text input -->
            <div class="form-group">
               <label>@lang('app.faq.question')</label>
               <input type="text" name="question" id="question" class="form-control form-control-lg" value="{{ $faq->question }}">
            </div>
         </div>
         <div class="col-md-12">
            <div class="form-group">
               <label>@lang('app.faq.answer')</label>
               <textarea name="answer" id="answer" cols="30" class="form-control-lg form-control"
                  rows="4">{!! $faq->answer !!}</textarea>
            </div>
         </div>
      </div>
      <div class="form-group">
         <button type="button" id="save-form" class="btn btn-success btn-light-round"><i
            class="fa fa-check"></i> @lang('app.save')</button>
      </div>
   </form>
</div>

<script>
    $('body').on('click', '#save-form', function() {
        const form = $('#editForm');

        $.easyAjax({
            url: '{{route('superadmin.front-faq.update', $faq->id)}}',
            container: '#editForm',
            type: "POST",
            redirect: true,
            data: form.serialize(),
            success: function (response) {
                if(response.status == 'success'){
                    window.location.reload();
                }
            }
        })
    });

    $(function () {
        $('#answer').summernote({
            dialogsInBody: true,
            height: 200,
            toolbar: [
            // [groupName, [list of button]]
            ['style', ['bold', 'italic', 'underline', 'clear']],
            ['font', ['strikethrough']],
            ['fontsize', ['fontsize']],
            ['para', ['ul', 'ol', 'paragraph']],
            ["view", ["fullscreen"]]
        ]
        })
    });
</script>
