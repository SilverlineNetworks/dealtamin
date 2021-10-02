<div class="modal-header">
    <h4 class="modal-title">@lang('app.edit') @lang('app.front.widget.title') </h4>
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
 </div>
 <div class="modal-body">
    <form role="form" id="editForm" class="ajax-form" method="POST">
       @csrf
       @method('PUT')
       <div class="row">

          <div class="col-md-12">
             <!-- text input -->
             <div class="form-group">
                <label>@lang('app.frontwidget.name')</label>
                <input type="text" name="name" id="name" class="form-control form-control-lg" value="{{ $widgets->name }}">
             </div>
          </div>
          <div class="col-md-12">
             <div class="form-group">
                <label>@lang('app.frontwidget.code')</label>
                <textarea name="code" id="code" cols="30" class="form-control-lg form-control"
                   rows="4">{{$widgets->code }}</textarea>
             </div>
          </div>
          <div class="col-md-12">
            <div class="form-group">
                <label>@lang('app.frontwidget.status')</label>
                <select name="status" id="status" class="form-control form-control-lg">

                    <option value="active">Active</option>
                    <option value="inactive">Inactive</option>

                </select>
            </div>
       </div>
       <div class="form-group">
          <button type="button" id="save-form" class="btn btn-success btn-light-round"><i
             class="fa fa-check"></i> @lang('app.update')</button>
       </div>
    </form>
 </div>

 <script>
     $('body').on('click', '#save-form', function() {
         const form = $('#editForm');

         $.easyAjax({
             url: '{{route('superadmin.front-widget.update', $widgets->id)}}',
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

 </script>
