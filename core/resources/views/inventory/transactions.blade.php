@extends('app')
@section('content')
<div class="col-md-12 content-header">
  <h1><i class="fa fa-puzzle-piece"></i> Transactions</h1>
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
                  <th width="15%">Date</th>
                  <th>Transaction Number</th>
                  <th class="text-center">Transaction type</th>
                  <th>Type Contact</th>
                  {{-- <th>Contact</th> --}}
                  <th>Courier</th>
                  <th>Tracking number</th>
                  <th>Reason - Type In</th>
                  <th>RMA/ PURCHASE ORDER Number #</th>
                  <th>Batch Number</th>
                  <th>Package List</th>
                  <th width="10%">{{ trans('application.action') }}</th>
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
      stateSave: true,
      dom: 'lBfrtip',
        buttons: [
            'excelHtml5',
        ],
      ajax: '{{ route('transactions') }}',
      order: [0, 'desc'],
      columnDefs: [{
        "orderable": false,
        "targets": 0
      }],
      oLanguage: {
        "sProcessing": "{{trans('application.processing')}}"
      },
      columns: [{
          data: 'date',
          orderable: true
        },
        {
          data: 'transaction_number',
          orderable: true
        },
        {
          data: 'transaction_types_id',
          orderable: true
        },
        {
          data: 'type_contact',
          orderable: true
        },
        // {
        //   data: 'contacts_id',
        //   orderable: true
        // },
        {
          data: 'couriers_id',
          orderable: true
        },
        {
          data: 'tracking_number',
          orderable: true
        },
        {
          data: 'transaction_types_in',
          orderable: true
        },
        {
          data: 'number_types_in',
          orderable: true
        },
        {
          data: 'batch_number',
          orderable: true
        },
        {
          data: 'package_list',
          orderable: true
        },
        {
          data: 'action',
          'searchable': false,
          orderable: false,
          className: "text-right",
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
