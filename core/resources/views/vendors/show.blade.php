@extends('app')
@section('content')
<div class="col-md-12 content-header">
  <h1><i class="fa fa-user"></i> Vendor Details</h1>
</div>
<section class="content">
  <div class="row">
    <div class="col-md-6">
      <div class="box box-solid">
        <div class="box-header with-border">
          <h3 class="box-title">{{ $vendor->name }}</h3>
        </div>

        <div class="box-body">
          <table class="table table-striped">
            <tr>
              <td style="width:30%"><dt>Vendor Number</dt></td>
              <td>{{ $vendor->_no }}</td>
            </tr>

            <tr>
              <td><dt>{{ trans('application.email') }}</dt></td>
              <td>{{ $vendor->email }}</td>
            </tr>

            <tr>
              <td><dt>{{ trans('application.phone') }}</dt></td>
              <td>{{ $vendor->phone }}</td>
            </tr>

            <tr>
              <td><dt>{{ trans('application.mobile') }}</dt></td>
              <td>{{ $vendor->mobile }}</td>
            </tr>

            <tr>
              <td><dt>{{ trans('application.address_1') }}</dt></td>
              <td>{{ $vendor->address1 }}</td>
            </tr>

            <tr>
              <td><dt>{{ trans('application.address_2') }}</dt></td>
              <td>{{ $vendor->address2 }}</td>
            </tr>
          </table>
        </div>
      </div>
    </div>
    <div class="col-md-6">
      <div class="box box-solid">
        <div class="box-body">
          <table class="table table-striped">
            <tr>
              <td style="width:30%"><dt>{{ trans('application.city') }}</dt></td>
              <td>{{ $vendor->city }}</td>
            </tr>
            <tr>
              <td><dt>{{ trans('application.state_province') }}</dt></td>
              <td>{{ $vendor->state }}</td>
            </tr>
            <tr>
              <td><dt>{{ trans('application.postal_zip') }}</dt></td>
              <td>{{ $vendor->postal_code }}</td>
            </tr>
            <tr>
              <td><dt>{{ trans('application.country') }}</dt></td>
              <td>{{ $vendor->Country }}</td>
            </tr>
            <tr>
              <td><dt>{{ trans('application.website') }}</dt></td>
              <td>{{ $vendor->website }}</td>
            </tr>
            <tr>
              <td><dt>{{ trans('application.contact_person') }}</dt></td>
              <td>{{ $vendor->contact_person }}</td>
            </tr>
            <tr>
              <td><dt>{{ trans('application.notes') }}</dt></td>
              <td>{{ $vendor->notes }}</td>
            </tr>
          </table>
        </div>
      </div>
    </div>
  </div>

  {{--
  <div class="row">
    <div class="col-md-12">
      <div class="box box-solid">
        <div class="box-header with-border">
          <h3 class="box-title">{{ trans('application.invoices') }}</h3>
        </div>
        <div class="box-body">
          <table class="table table-bordered table-striped table-hover datatable">
            <thead>
              <tr>
                <th width="10%"></th>
                <th>{{ trans('application.invoice_number') }}</th>
                <th>{{ trans('application.status') }}</th>
                <th>{{ trans('application.date') }}</th>
                <th>{{ trans('application.due_date') }}</th>
                <th>{{ trans('application.amount') }}</th>
                <th width="20%">{{ trans('application.action') }}</th>
              </tr>
            </thead>
            <tbody>
              @foreach($client->invoices as $invoice)
                <tr>
                  <td></td>
                  <td><a href="{{ route('invoices.show', $invoice->uuid ) }}">{{ $invoice->number }}</a> </td>
                  <td><span class="label {{ statuses()[$invoice->status]['class'] }}">{{ ucwords(statuses()[$invoice->status]['label']) }} </span></td>
                  <td>{{ $invoice->invoice_date }} </td>
                  <td>{{ $invoice->due_date }} </td>
                  <td>{{ $invoice->currency.''.$invoice->totals['grandTotal'] }} </td>
                  <td>
                    <a href="{{ route('invoices.show',$invoice->uuid) }}" class="btn btn-xs btn-info"><i class="fa fa-eye"></i> {{ trans('application.view') }} </a>
                  </td>
                </tr>
                @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>
    <div class="col-md-12">
      <div class="box box-solid">
        <div class="box-header with-border">
          <h3 class="box-title">{{ trans('application.estimates') }}</h3>
        </div>

        <div class="box-body">
          <table class="table table-bordered table-striped table-hover datatable">
            <thead>
              <tr>
                <th width="10%"></th>
                <th>{{ trans('application.estimate_number') }}</th>
                <th>{{ trans('application.date') }}</th>
                <th>{{ trans('application.amount') }}</th>
                <th width="20%">{{ trans('application.action') }}</th>
              </tr>
            </thead>
            <tbody>
              @foreach($client->estimates as $count => $estimate)
                <tr>
                  <td>{{ $count+1 }}</td>
                  <td><a href="{{ route('estimates.show', $estimate->uuid ) }}">{{ $estimate->estimate_no }}</a> </td>
                  <td>{{ $estimate->estimate_date }} </td>
                  <td>{{ $estimate->currency.''.$estimate->totals['grandTotal'] }} </td>
                  <td>
                    <a href="{{route('estimates.show',$estimate->uuid)}}" class="btn btn-xs btn-info"><i class="fa fa-eye"></i> {{ trans('application.view') }} </a>
                  </td>
                </tr>
                @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
  --}}

</section>
@stop
