@extends('app')
@section('content')
<div class="col-md-12 content-header">
  <h1><i class="fa fa-puzzle-piece"></i> Inventory</h1>
</div>
<section class="content">
  <div class="row">
    <div class="col-md-12">
      <div class="box  box-primary">
        @if(hasPermission('add_product'))
        <div class="box-header with-border">
          @include('inventory.partials.buttons_actions')
        </div>
        @endif
        <div class="box-body">
          <div class="table-responsive">
            <table class="table table-bordered table-striped table-hover ajax_datatable">
              <thead>
                <tr>
                  <th width="10%">Image</th>
                  <th>{{trans('application.name')}}</th>
                  <th>{{trans('application.code_product')}}</th>
                  <th>{{trans('application.model')}}</th>
                  <th>{{trans('application.category')}}</th>
                  {{-- <th>{{trans('application.price')}}</th> --}}
                  <th>{{trans('application.quantity')}}</th>
                  <th>{{trans('application.quantity_rma')}}</th>
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
      serverSide: false,
      dom: 'lBfrtip',
        buttons: [
            'excelHtml5',
        ],
      stateSave: true,
      ajax: '{{ route('products.index') }}',
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
          orderable: true
        },
        {
          data: 'code',
          orderable: true
        },
        {
          data: 'model',
          orderable: false
        },
        {
          data: 'category',
          name: "product_categories.name",
          orderable: true
        },
        // {
        //   data: 'price',
        //   'searchable': false,
        //   className: "text-right",
        //   orderable: false
        // },
        {
          data: 'quantity',
          orderable: true
        },
        {
          data: 'quantity_rma',
          orderable: true
        }

      ]
    });
    $('div.dataTables_filter input').addClass('form-control input-sm');
    $('div.dataTables_length select').addClass('form-control input-sm');

    $('.dt-buttons').addClass('pull-right');
    $('.dt-button').prop('title', 'Export');
    $('#DataTables_Table_0_length').addClass('float-right ml-3 position_ajust');
    
    $('.buttons-excel').html('<i class="fa fa-file"></i> Export Excel'); 
    $('.buttons-excel').addClass('btn-xs btn-primary');
    $('.buttons-excel').prop('style','margin-left: 10px;');

  });
  $(document).ajaxComplete(function() {
    $('[data-toggle="popover"]').popover();
  });
</script>
@stop
