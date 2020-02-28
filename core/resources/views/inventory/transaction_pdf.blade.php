<!DOCTYPE html>
<html lang="en"><head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta charset="UTF-8">
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <link href='http://fonts.googleapis.com/css?family=Ruda&subset=latin,latin-ext' rel='stylesheet' type='text/css'>
    <!-- Bootstrap 3.3.2 -->
    <link href="{{ asset('assets/css/dataTables.bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- Bootstrap 3.3.2 -->
    <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- Font Awesome Icons -->
    <link href="{{ asset('assets/css/font-awesome.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- Theme style -->
    <link href="{{ asset('assets/css/theme.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- AdminLTE Skins. Choose a skin from the css/skins-->
    <link href="{{ asset('assets/css/theme-skin.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/css/pace.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/plugins/pikaday/pikaday.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/plugins/chosen/chosen.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/plugins/animsition/css/animsition.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('assets/plugins/amaranjs//css/amaran.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('assets/css/style.css') }}" rel="stylesheet" type="text/css" />
</head><body>
<div class="container">
  <div class="content-wrapper">
    <div class="col-md-12 content-header">
      <h1>{{ trans('application.transaction_details') }}</h1>
    </div>
    <section class="content">
  <div class="row">
    <div class="col-md-6">
      <div class="box box-solid">
        <div class="box-header with-border">
          <h3 class="box-title">{{ trans('application.check') }}{{ $transaction->transactiontypes->name }} - {{ trans('application.transaction_number') }} # {{ $transaction->transaction_number }}</h3>
        </div>

        <div class="box-body">
          <table class="table table-striped">
            <tr>
              <td><dt>{{ trans('application.date') }}</dt></td>
              <td>{{ date('m-d-Y', strtotime($transaction->date)) }}</td>
            </tr>
            <tr>
              <td style="width:30%"><dt>{{ trans('application.type_contact') }}</dt></td>
              <td>
                @if($transaction->type_contact == 0)
                  {{ trans('application.client') }}
                @else
                  {{ trans('application.vendor') }}
                @endif
              </td>
            </tr>

            <tr>
              <td><dt>{{ trans('application.contact') }}</dt></td>
              <td>
                @if(isset($contact->name))
                    {!! $contact->name !!}
                @endif
              </td>
            </tr>

            <tr>
              <td><dt>{{ trans('application.courier') }}</dt></td>
              <td>
                @if(isset($transaction->courier->name))
                  {{ $transaction->courier->name }}
                @endif
                </td>

            </tr>

            <tr>
              <td><dt>{{ trans('application.tracking_number') }}</dt></td>
              <td>{{ $transaction->tracking_number }}</td>
            </tr>

            <tr>
              <td><dt>
                  @if ($transaction->transactiontypes->type == 'in') 
                    {{ trans('application.transaction_types_in') }}
                  @else
                    {{ trans('application.transaction_types_out') }}
                  @endif
                  
              </dt></td>
              <td>
                @if($transaction->transaction_types_in == 0)
                  {{ trans('application.purchase') }}
                @else
                  {{ trans('application.rma') }}
                @endif
              </td>
            </tr>

            <tr>
              <td><dt>
                      @if ($transaction->transactiontypes->type == 'in') 
                          {{ trans('application.number_types_in') }}
                      @else
                        {{ trans('application.number_types_out') }}
                      @endif
              </dt></td>
              <td>{{ $transaction->number_types_in }}</td>
            </tr>
          </table>
        </div>
      </div>
    </div>
    <div class="col-md-6">
      <div class="box box-solid">
        <div class="box-header with-border">
          <h3 class="box-title"></h3>
        </div>
        <div class="box-body">
          <table class="table table-striped">

            <tr>
              <td style="width:30%"><dt>{{ trans('application.bol') }}</dt></td>
              <td>{{ $transaction->bol }}</td>
            </tr>
             <tr>
              <td><dt>{{ trans('application.batch_number') }}</dt></td>
              <td>{{ $transaction->batch_number }}</td>
            </tr>
            <tr>
              <td><dt>{{ trans('application.package_list') }}</dt></td>
              <td>{{ $transaction->package_list }}</td>
            </tr>
            <tr>
              <td><dt>{{ trans('application.username') }}</dt></td>
              <td>
                @if (isset($transaction->users->name))
                  {{ $transaction->users->name }}
                @endif
              </td>
            </tr>
            <tr>
              <td><dt>{{ trans('application.notes') }}</dt></td>
              <td>{{ $transaction->notes }}</td>
            </tr>
          </table>
        </div>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-md-12">
      <div class="box box-solid">
        <div class="box-header with-border">
          <h3 class="box-title">{{ trans('application.transactions_items') }}</h3>
        </div>

        <div class="box-body">
          <table class="table table-bordered table-striped table-hover datatable">
            <thead>
              <tr>
                <th width="10%">#</th>
                <th>{{ trans('application.product') }}</th>
                <th class="text-center">{{ trans('application.quantity') }}</th>
              </tr>
            </thead>
            <tbody>
              @php($counter=0)
               @if(isset($transaction->transactionItems))
                @foreach($transaction->transactionItems as $count => $item)
                  @php($counter=$counter+1)
                  <tr>
                    <td>{{ $counter }}</td>
                    <td>
                      @if(isset($transaction->transactionItems[$count]->product->name))
                        {{ $transaction->transactionItems[$count]->product->name }}
                      @endif
                      </td>
                    <td class="text-center">
                        @if(isset($transaction->transactionItems[$count]->quantity))
                          {{ $transaction->transactionItems[$count]->quantity }}
                        @endif
                    </td>
                  </tr>
                @endforeach
              @endif
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</section>
</div>
<!-- jQuery 2.1.3 -->
<script src="{{ asset('assets/js/jquery-2.1.3.min.js') }}"></script>
<!-- Bootstrap 3.3.2 JS -->
<script src="{{ asset('assets/js/bootstrap.min.js') }}" type="text/javascript"></script>
<!-- Bootstrap Dialog -->
<script src="{{ asset('assets/js/bootstrap-dialog.js') }}"></script>
<!-- Jquery Datatables -->
<script src="{{ asset('assets/js/jquery.dataTables.js') }}"></script>
<!-- Datatables -->
<script src="{{ asset('assets/js/datatables.js') }}"></script>
<!-- summernote.js javascript -->
<script src="{{ asset('assets/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js') }}"></script>
<!-- chosen.js javascript-->
<script src="{{ asset('assets/plugins/chosen/chosen.jquery.js') }}"></script>
<script src="{{ asset('assets/plugins/animsition/js/jquery.animsition.min.js') }}" type="text/javascript"></script>
<!-- validator.js javascript-->
<script src="{{ asset('assets/js/validator.min.js') }}"></script>
<!-- custom.js -->
<script src="{{ asset('assets/js/app.js') }}"></script>
<script src="{{ asset('assets/js/custom.js') }}"></script>
</body></html>
