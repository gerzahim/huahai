@extends('app')
@section('content')
<div class="col-md-12 content-header">
  <h1><i class="fa fa-puzzle-piece"></i> {{trans('application.products')}}</h1>
</div>
<section class="content">
  <div class="row">
    <div class="col-md-12">
      <div class="box  box-primary">
        @if(hasPermission('add_product'))
        <div class="box-header with-border">
          <h3 class="box-title pull-right">
                            <div class="box-tools">
                                <a href="{{ route('products.create') }}" class="btn btn-primary btn-xs pull-right"> <i class="fa fa-plus"></i> {{trans('application.new_product')}}</a>
                                <a href="{{ route('product_category.index') }}" class="btn btn-info btn-xs pull-right" style="margin-right: 10px;"><i class="fa fa-bars"></i> {{trans('application.categories')}}</a>
                            </div>
                        </h3>
        </div>
        @endif
        <div class="box-body">
          <div class="table-responsive">
            <table class="table table-bordered table-striped table-hover ajax_datatable">
              <thead>
                <tr>
                  <th width="10%">Image</th>
                  <th>{{trans('application.product_name')}}</th>
                  <th>{{trans('application.code_product')}}</th>
                  <th>Model</th>
                  <th>{{trans('application.brand')}}</th>
                  <th>{{trans('application.category')}}</th>
                  {{-- <th>{{trans('application.price')}}</th> --}}
                  <th>{{trans('application.action')}} </th>
                </tr>
              </thead>
              <tbody></tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
@stop
@section('scripts')
<script type="text/javascript">
  $(document).ready(function() {
    $('.ajax_datatable').DataTable({
      processing: true,
      serverSide: true,
      stateSave: true,
      ajax: '{{route('products.index')}}',
      order: [],
      columnDefs: [{
        "orderable": false,
        "targets": 0
      }],
      oLanguage: {
        "sProcessing": "{{trans('application.processing')}}"
      },
      columns: [{
          data: 'image',
          orderable: false
        },
        {
          data: 'name',
          orderable: false
        },
        {
          data: 'code',
          orderable: false
        },
        {
          data: 'model',
          orderable: false
        },
        {
          data: 'brand',
          orderable: false
        },
        {
          data: 'category',
          name: "product_categories.name",
          orderable: false
        },
        // {
        //   data: 'price',
        //   'searchable': false,
        //   className: "text-right",
        //   orderable: false
        // },
        {
          data: 'action',
          'searchable': false,
          orderable: false,
          className: "text-right"
        }
      ]
    });
    $('div.dataTables_filter input').addClass('form-control input-sm');
    $('div.dataTables_length select').addClass('form-control input-sm');
  });
  $(document).ajaxComplete(function() {
    $('[data-toggle="popover"]').popover();
  });
</script>
@stop
