@extends('app')
@section('content')
<div class="col-md-12 content-header">
  <h1><i class="fa fa-users"></i> {{ trans('application.clients') }}</h1>
</div>
<section class="content">
  <div class="row">
    <div class="col-md-12">
      <div class="box box-primary">
        @if(hasPermission('add_client'))
        <div class="box-header with-border">
          <h3 class="box-title pull-right">
                    <div class="box-tools">
                            <a href="{{ route('clients.create') }}" class="btn btn-primary btn-sm" data-toggle="ajax-modal"> <i class="fa fa-user-plus"></i> {{ trans('application.new_client') }}</a>
                    </div>
                    </h3>
        </div>
        @endif
        <div class="box-body">
          <div class="table-responsive">
            <table class="table table-hover table-bordered table-striped ajax_datatable">
              <thead>
                <tr>
                  <th>{{ trans('application.photo') }}</th>
                  <th>{{ trans('application.reference') }}</th>
                  <th>{{ trans('application.name') }}</th>
                  <th>{{ trans('application.email') }}</th>
                  <th>{{ trans('application.phone') }}</th>
                  <th>{{ trans('application.country') }}</th>
                  <th>{{ trans('application.action') }}</th>
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
      ajax: '{{route('clients.index')}}',
      order: [],
      columnDefs: [{
        "orderable": false,
        "targets": 0
      }],
      oLanguage: {
        "sProcessing": "{{trans('application.processing')}}"
      },
      columns: [{
          data: 'photo'
        },
        {
          data: 'client_no'
        },
        {
          data: 'name'
        },
        {
          data: 'email'
        },
        {
          data: 'phone'
        },
        {
          data: 'country'
        },
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
</script>
@stop