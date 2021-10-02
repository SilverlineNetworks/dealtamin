<style>
    .dropify-wrapper, .dropify-preview, .dropify-render img {
        background-color: var(--sidebar-bg) !important;
    }
</style>

<div class="modal-header">
   <h4>@lang('menu.frontPopularStoreSettings')</h4>
   <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
</div>

<div class="modal-body">
   <section class="mt-3 mb-3">
      <form class="form-horizontal ajax-form" id="addForm" method="POST">
         @csrf
         <div class="row">
            <div class="col-md-12">
               <div class="form-group">
                  <h6 class="col-md-12 text-primary">@lang('app.select') @lang('app.company')</h6>
                  <select name="store_id" id="store_id" class="form-control  form-control-lg">
                     <option value=""></option>
                     @foreach($stores as $store)
                     @if($store->popular_store != 1)
                     <option value="{{ $store->id }}">{{ $store->company_name }}</option>
                     @endif
                     @endforeach
                  </select>
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

    $('body').on('click', '#save-form', function() {
        const form = $('#addForm');

        $.easyAjax({
            url: '{{route('superadmin.popular-stores.store')}}',
            container: '#addForm',
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
