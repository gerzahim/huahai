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

              {!! Form::model($transaction, ['route' => ['inventory.update', $transaction->uuid], 'method' => 'PATCH']) !!}
                  
                <div class="form-group">
                  
                  <input type="hidden" name="uuid" value="{{ $transaction->uuid }}">
                  <input type="hidden" name="transaction_number" value="{{ $transaction_number }}">
                  
                  <div class="col-sm-12">
                    <div class="col-sm-6">
                      <label>{{ trans('application.date') }}: </label>
                      <div class="form-group input-group">
                          <input class="form-control input-sm date" size="16" type="text" readonly name="date" id="date"  value="{{ date('m-d-Y', strtotime($transaction->date)) }}"/>
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
                                    <option @if($transaction->type_contact == 0) selected="selected" @endif value="0">Clients</option>
                                    <option @if($transaction->type_contact == 1) selected="selected" @endif value="1">Vendors</option>
                        </select>
                      </div>
                    </div>

                    <div class="col-sm-6">
                      <div class="form-group" id="divclient" @if ($transaction->type_contact == 1) style="display: none;" @endif>
                        <label for="client_id" >Client</label> 
                          <select id="client_id" class="form-control input-sm chosen" name="contacts_client_id">
                              @foreach ($clients as $index => $client)                            
                                <option value="{{ $index }}" @if ($transaction->contacts_id == $index) selected @endif>{{ $client }}</option>
                              @endforeach
                          </select>
                      </div>
                    </div>
                        
                    <div class="col-sm-6">
                      <div class="form-group" id="divvendor" @if ($transaction->type_contact == 0) style="display: none;" @endif>
                        <label for="vendor_id">Supplier</label> 
                          <select id="vendor_id" class="form-control input-sm chosen" name="contacts_vendor_id">
                              @foreach ($vendors as $index => $vendor)                            
                                  <option value="{{ $index }}" @if ($transaction->contacts_id == $index) selected @endif>{{ $vendor }}</option>
                              @endforeach
                          </select> 
                      </div>
                    </div>
                  </div>

                </div>
                <div class="form-group">
                  <div class="col-sm-12">
                    <div class="col-sm-6">
                      <label for="couriers_id">Courier</label> 
                        <select class="form-control input-sm chosen" id="couriers_id" name="couriers_id">
                          @foreach ($couriers as $index => $courier)      
                            <option value="{{ $index }}" @if ($transaction->couriers_id == $index) selected @endif>{{ $courier }}</option>
                          @endforeach
                        </select>
                    </div>
                    <div class="col-sm-6">
                      {!! Form::label('tracking1', 'Tracking Number / Document Number') !!} {!! Form::text('tracking_number', $transaction->tracking_number, ['class' => 'form-control input-sm']) !!}

                    </div>
                  </div>
                </div>
                <div class="form-group">
                  <div class="col-sm-12">
                    <div class="col-sm-6">
                      <div class="form-group">
                        <label for="transaction_types_in1">Reason - Type In</label>
                            <select id="transaction_types_in" name="transaction_types_in" class="form-control input-sm ">
                                <option @if ($transaction->transaction_types_in == '0') selected="selected" @endif value="0">Purchase</option>
                                <option @if ($transaction->transaction_types_in == '1') selected="selected" @endif value="1">RMA</option>
                            </select>
                      </div>
                    </div>
                    <div class="col-sm-6">
                      {!! Form::label('number_types_in1', 'RMA/ PURCHASE ORDER Number #') !!} {!! Form::text('number_types_in', $transaction->number_types_in, ['class' => 'form-control input-sm']) !!}

                    </div>
                  </div>
                </div>
                <div class="form-group">
                  <div class="col-sm-12">
                    <div class="col-sm-6">
                      {!! Form::label('bol1', 'Bill of Landing') !!} {!! Form::text('bol', $transaction->bol, ['class' => 'form-control input-sm']) !!}

                    </div>
                    <div class="col-sm-6">
                      {!! Form::label('batch_number1', 'Batch Number') !!} {!! Form::text('batch_number', $transaction->batch_number, ['class' => 'form-control input-sm']) !!}

                    </div>
                  </div>
                </div>
                <div class="form-group">
                  <div class="col-sm-12">
                    <div class="col-sm-6">
                      {!! Form::label('package_list', 'Package List Number') !!} {!! Form::text('package_list', $transaction->package_list, ['class' => 'form-control input-sm']) !!}
                    </div>

                    <div class="col-sm-6">
                        {!! Form::label('notes', 'Notes') !!} {!! Form::textarea('notes', $transaction->notes, ['rows' => 3, 'class' => 'form-control input-sm']) !!}
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
                        @foreach ($items as $item)
                          <tr class="item">
                            <td class="inventory-arsernal-vat"><span class='btn btn-danger btn-xs delete_row'><i class='fa fa-minus'></i></span></td>
                            <td>
                              <div class="form-group">
                                {!! Form::text('item_name[]', $item->product->name, ['class' => 'form-control input-sm item_name', 'id'=>"item_name", 'readonly']) !!}
                                {!! Form::text('product_id[]',$item->product_id, ['class' => 'form-control input-sm item_name hidden', 'id'=>"product_id"]) !!}
                              </div>
                            </td>
                            <td>
                              <div class="form-group">{!! Form::input('number','quantity[]',$item->quantity, ['class' => 'form-control calcEvent quantity input-sm text-center', 'id'=>"quantity" , 'required', 'step' => 'any', 'min' => '0']) !!}</div>
                            </td>
                          </tr>
                        @endforeach 
                      
                    </tbody>
                  </table> 
                </div>
                <div class="col-md-6">
                  <span id="btn_product_list_modal" class="btn btn-sm btn-primary "><i class="fa fa-plus"></i> {{ trans('application.add_from_products') }}</span>
                  {!! Form::submit(trans('Save'), ['class' => "btn btn-primary btn-sm"]) !!}
                </div>

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
          $('.date').pikaday({ field: document.getElementById('datepicker1'), firstDay: 1, format:'MM-DD-YYYY', autoclose:true });
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
