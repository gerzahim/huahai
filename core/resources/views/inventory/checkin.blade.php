@extends('app')
@section('content')
<div class="col-md-12 content-header">
  <h1><i class="fa fa-puzzle-piece"></i> Check-In Products</h1>
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

            <div class="modal-content">
                         <div class="modal-header">
                            <h3 class="modal-title">{{trans('application.transaction_number')}} <b># {{ $transaction_number }}</b></h3>
                        </div>
              @if (isset($errors) && count($errors) > 0) {!! form_errors($errors) !!}
              @endif
              <form action="{{ route('checkin') }}" method="post" id="create-form" enctype="multipart/form-data">

                <div class="form-group">

                  <div class="col-sm-12">
                    <div class="col-sm-6">
                      <label>{{ trans('application.date') }} : </label>
                      <div class="form-group input-group">
                          <input class="form-control input-sm date" size="16" type="text" name="date" readonly id="date"/>
                          <span class="input-group-addon input-sm add-on"><i class="fa fa-calendar" style="display: inline"></i></span>
                      </div>
                    </div>
                    <div class="col-sm-6">
                    </div>
                  </div>

                  <div class="col-sm-12">
                    <div class="col-sm-6">

                      <label class="form-check-label" for="card-number">Select Type of Contact or Shipper  (Client or Supplier )</label>


                      <div class="form-check">
                        <select id="type_contact" name="type_contact" class="form-control input-sm ">

                                              <option selected="selected" value="0">Clients</option>
                                              <option value="1">Vendors</option>
                                  </select>
                      </div>
                    </div>
                    <div class="col-sm-6">
                      <div class="form-group" id="divclient">
                        {!! Form::label('client_id', 'Client', ['id' => '333']) !!} {!! Form::select('contacts_client_id', $clients, null, ['id' => '4446', 'class' => 'form-control input-sm chosen']) !!}
                      </div>
                      <div class="form-group" id="divvendor">
                        {!! Form::label('vendor_id', 'Supplier') !!} {!! Form::select('contacts_vendor_id', $vendors, null, ['class' => 'form-control input-sm chosen']) !!}
                      </div>
                    </div>

                  </div>

                </div>
                <div class="form-group">
                  <div class="col-sm-12">
                    <div class="col-sm-6">
                      {!! Form::label('couriers_id', 'Courier') !!} {!! Form::select('couriers_id', $couriers, null, ['class' => 'form-control input-sm chosen']) !!}

                    </div>
                    <div class="col-sm-6">
                      {!! Form::label('tracking1', 'Tracking Number / Document Number') !!} {!! Form::text('tracking_number', null, ['class' => 'form-control input-sm']) !!}

                    </div>
                  </div>
                </div>
                <div class="form-group">
                  <div class="col-sm-12">
                    <div class="col-sm-6">
                      <div class="form-group">
                        {!! Form::label('transaction_types_in1', 'Reason - Type In') !!}
                        <select id="transaction_types_in" name="transaction_types_in" class="form-control input-sm ">
                                              <option selected="selected" value="0">Purchase</option>
                                              <option value="1">RMA</option>
                                  </select>
                      </div>
                    </div>
                    <div class="col-sm-6">
                      {!! Form::label('number_types_in1', 'RMA/ PURCHASE ORDER Number #') !!} {!! Form::text('number_types_in', null, ['class' => 'form-control input-sm']) !!}

                    </div>
                  </div>
                </div>
                <div class="form-group">
                  <div class="col-sm-12">
                    <div class="col-sm-6">
                      {!! Form::label('bol1', 'Bill of Landing') !!} {!! Form::text('bol', null, ['class' => 'form-control input-sm']) !!}

                    </div>
                    <div class="col-sm-6">
                      {!! Form::label('batch_number1', 'Batch Number') !!} {!! Form::text('batch_number', null, ['class' => 'form-control input-sm']) !!}

                    </div>
                  </div>
                </div>
                <div class="form-group">
                  <div class="col-sm-12">
                    <div class="col-sm-6">
                      {!! Form::label('package_list', 'Package List Number') !!} {!! Form::text('package_list', null, ['class' => 'form-control input-sm']) !!}
                    </div>

                    <div class="col-sm-6">
                        {!! Form::label('notes', 'Notes') !!} {!! Form::textarea('notes', null, ['rows' => 3, 'class' => 'form-control input-sm']) !!}
                    </div>
                  </div>
                </div>

                <div class="form-group">
                  <div class="col-sm-12">
                    <hr>
                  </div>
                </div>
                {{ csrf_field() }}

                <div class="col-md-12">
                  <h1>Check-IN</h1>
                  <table class="table table-striped" id="item_table">
                    <thead class="item-table-header">
                      <tr>
                        <th width="5%"></th>
                        <th width="20%">{{ trans('application.product') }}</th>
                        <th width="10%" class="text-center">{{trans('application.quantity')}}</th>
                        {{-- <th width="5%"></th> --}}
                      </tr>
                    </thead>
                    <tbody>
                      <tr class="item">
                        <td class="inventory-arsernal-vat"><span class='btn btn-danger btn-xs delete_row'><i class='fa fa-minus'></i></span></td>
                        <td>
                          <div class="form-group">
                            {!! Form::text('item_name[]',null, ['class' => 'form-control input-sm item_name', 'id'=>"item_name" , 'required', 'readonly']) !!}
                            {!! Form::text('product_id[]',null, ['class' => 'form-control input-sm item_name hidden', 'id'=>"product_id" , 'required']) !!}
                          </div>
                        </td>
                        <td>
                          <div class="form-group">{!! Form::input('number','quantity[]',null, ['class' => 'form-control calcEvent quantity input-sm text-center', 'id'=>"quantity" , 'required', 'step' => 'any', 'min' => '0']) !!}</div>
                        </td>
                        {{-- <td class="inventory-arsernal-vat"><spam name="add_serial" alt="Add serial number" class='btn btn-success btn-xs add_serial_number'><i class='fa fa-plus'></i></spam></td>  --}}
                      </tr>
                    </tbody>
                  </table>
                </div>
                <div class="col-md-6">
                  <span id="btn_product_list_modal" class="btn btn-sm btn-primary "><i class="fa fa-plus"></i> {{ trans('application.add_from_products') }}</span>
                  {!! Form::submit(trans('Save'), ['class' => "btn btn-primary btn-sm"]) !!}
                </div>

                {{-- <div class="form-group">
                  <div class="col-sm-6"> </div>
                  <div class="col-sm-6">
                    <button type="button" onclick="myFunction()" class="btn btn-success">Scan Item</button>
                  </div>
                </div> --}}
                {{-- <div class="form-group">
                  <div class="col-sm-12">
                    <p id="demo"></p>

                  </div>
                </div>
                <div class="form-group">
                  <div class="col-sm-6"> </div>
                  <div class="col-sm-6">

                  </div>
                </div> --}}
                {!! Form::close() !!}





            </div>


          </div>
        </div>
      </div>
    </div>
  </div>
</section>
@stop
@section('scripts')
  @include('inventory.partials._checkinjs')


  <script type="text/javascript">
      $(function() {
          $('.date').pikaday({ field: document.getElementById('datepicker1'), firstDay: 1, format:'MM-DD-YYYY', autoclose:true, defaultDate: moment().toDate(), setDefaultDate: true });
      });
  </script>
  {{--  Script para Datatable --}}
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
  </script>




<script type="text/javascript">
  document.getElementById('divvendor').style.display = 'none';
</script>
<script type="text/javascript">
  var token = '{{ Session::token() }}';
  var url = '{{ route('addcheckin') }}';
</script>

<script type="text/javascript">
  {
    {
      function myFunction() {

        var item = prompt("Please enter SkuCode", "Sku001");
        if (item === null || item == "") {
          /* $("#demo").append("<b> BAD DATA </b>"); */
        } else {
          /* AjaxController to Check if Item Exit  */

          /* var data = 'id='+ item  & '_token='+ token;   */


          $.ajax({
            method: "POST",
            url: url,
            /* data: dataString,  */

            error: function() {
              alert(token);
            },
            data: {
              id: item,
              _token: token
            },
            /*  data: data,  */
            success: function(data) {
              console.log(data);


              if (data.sku === undefined) {

                /* $("#demo").append( data +" -> Item Not Found !</b></br>");  */
                /* var n = $( "#demo" ).length;                */

                /* alert(item);  */
                /* addText(item);  */
                $("#demo").append("Sku001 -> Item Not Found !</b></br>");
                myFunction();
                /* return data.sku;  */

                /* addText(data.sku);  */


              } else {
                $("#demo").append("<b>App " + data.sku + data.name + "</b></br>");
                myFunction();
              }

            }


          });


        }


      }
    }
  }

  function isEven(number) {

    if (number % 2 === 0) {
      return true;
    } else {
      return false;
    }
  };


  function myFunctionWhile() {

    var text = "";
    var i = 0;
    do {
      // wait(5000);
      //setTimeout(function(){ myFunction(); }, 2000);
      myFunction();
      $("#demo").append("The number is " + i);
      //text += "The number is " + i;
      i++;
    }
    while (i < 9);

  }

  function addText(data) {

    var text = "";
    var i = 0;
    $("#demo").append(data + " -> Itemr Not Found !</b></br>");
    //var n = $( "#demo" ).length;
    //alert(n)
    //myFunction();
    //break;
    //alert("Item Not Found !");
  }
</script>
@stop
