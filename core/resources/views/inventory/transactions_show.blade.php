@extends('app')
@section('content')
<div class="col-md-12 content-header">
  <h1><i class="fa fa-list"></i> {{ trans('application.transaction_details') }}
      <spam class="pull-right"><a href="{{ route('transactions') }}" class="btn btn-primary btn-xs" title="Back to Transactions"> <i class="fa fa-chevron-left"></i> </a></spam>
  </h1>
</div>
<section class="content">
  <div class="row">
    <div class="col-md-6">
      <div class="box box-solid">
        <div class="box-header with-border">
          <h3 class="box-title">{{ trans('application.check') }}-{{ $transaction->transactiontypes->name }} {{ trans('application.transaction_number') }} # {{ $transaction->transaction_number }} </h3>
          <a class="pull-right btn btn-info btn-xs" data-rel="tooltip" data-placement="top" title="Print Transaction" href="{{ url('transaction/print/'. $transaction->uuid) }}"><i class="fa fa-print"></i></a>
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
                    {{ $contact->name }}
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
              @if ($transaction->transactiontypes->type == 'in') 
                @if($transaction->transaction_types_in == 0)
                  {{ trans('application.purchase') }}
                @else
                  {{ trans('application.rma') }}
                @endif
              @else
                  @if($transaction->transaction_types_in == 0)
                    {{ trans('application.sales') }}
                  @elseif($transaction->transaction_types_in == 1)
                    {{ trans('application.loan') }}
                  @else
                    {{ trans('application.rma_out') }}
                  @endif
              @endif
              </td>
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
              <td><dt>@if ($transaction->transactiontypes->type == 'in') 
                          {{ trans('application.number_types_in') }}
                      @else
                        {{ trans('application.number_types_out') }}
                      @endif
                  </dt>
              </td>
              <td>{{ $transaction->number_types_in }}</td>
            </tr>
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
                <th class="text-center">
                @if ($transaction->transactiontypes->type == 'in') 
                  @if($transaction->transaction_types_in == 0)
                    {{ trans('application.quantity') }}
                  @else
                    {{ trans('application.quantity_rma') }}
                  @endif
                @else
                    @if($transaction->transaction_types_in == 2)
                      {{ trans('application.quantity_rma') }}
                    @else
                      {{ trans('application.quantity') }}
                    @endif
                @endif
                </th>
                <th width="15%">{{ trans('application.serial_number') }}</th>
              </tr>
            </thead>
            <tbody>
              @if(isset($transaction->transactionItems))
                @foreach($transaction->transactionItems as $count => $item)
                  <tr>
                    <td></td>
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
                    <td class="inventory-arsernal-vat text-center">
                      @if (isset($countSerialNumbers[$transaction->transactionItems[$count]->uuid]))
                        @if ($countSerialNumbers[$transaction->transactionItems[$count]->uuid] < $transaction->transactionItems[$count]->quantity)
                          <spam class='btn btn-success btn-xs add_serial_number' data-transaction_id="{{ $transaction->transactionItems[$count]->transaction_id }}" data-transaction_item_id="{{ $transaction->transactionItems[$count]->uuid }}" data-product-id="{{ $transaction->transactionItems[$count]->product_id }}" data-quantity="{{ $transaction->transactionItems[$count]->quantity }}"><i class='fa fa-plus'></i></spam>
                        @endif
                      @else
                        <spam class='btn btn-success btn-xs add_serial_number' data-transaction_id="{{ $transaction->transactionItems[$count]->transaction_id }}" data-transaction_item_id="{{ $transaction->transactionItems[$count]->uuid }}" data-product-id="{{ $transaction->transactionItems[$count]->product_id }}" data-quantity="{{ $transaction->transactionItems[$count]->quantity }}"><i class='fa fa-plus'></i></spam>
                      @endif
                      @if (in_array($transaction->transactionItems[$count]->uuid, $serialNumbers))
                        <spam class='btn btn-success btn-xs show_serial_number' data-transaction_item_id="{{ $transaction->transactionItems[$count]->uuid }}"><i class='fa fa-eye'></i></spam>
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

@stop
@section('scripts')
    @include('inventory.partials._serial_number_js')

@stop
