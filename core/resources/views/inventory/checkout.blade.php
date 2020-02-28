@extends('app')
@section('content')
<div class="col-md-12 content-header">
  <h1><i class="fa fa-puzzle-piece"></i> Check-Out Products</h1>
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
              <form action="{{ route('checkout') }}" method="post" id="create-form" enctype="multipart/form-data">

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
                        {!! Form::label('transaction_types_in1', 'Reason - Type Out') !!}
                        <select id="transaction_types_in" name="transaction_types_in" class="form-control input-sm ">
                                              <option selected="selected" value="0">Sales</option>
                                              <option value="1">Loan</option>
                                              <option value="2">RMA OUT</option>
                                  </select>
                      </div>
                    </div>
                    <div class="col-sm-6">
                      {!! Form::label('number_types_in1', 'RMA / INVOICE / REF #') !!} {!! Form::text('number_types_in', null, ['class' => 'form-control input-sm']) !!}

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
                  <h1>Check-OUT</h1>
                  <table class="table table-striped" id="item_table">
                    <thead class="item-table-header">
                      <tr>
                        <th width="5%"></th>
                        <th width="20%">{{ trans('application.product') }}</th>
                        <th width="10%" class="text-center">{{trans('application.quantity')}}</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr class="item">
                        <td><span class='btn btn-danger btn-xs delete_row'><i class='fa fa-minus'></i></span></td>
                        <td>
                          <div class="form-group">
                            {!! Form::text('item_name[]',null, ['class' => 'form-control input-sm item_name', 'id'=>"item_name" , 'required', 'readonly']) !!}
                            {!! Form::text('product_id[]',null, ['class' => 'form-control input-sm item_name hidden', 'id'=>"item_name" , 'required']) !!}
                          </div>
                        </td>
                        <td>
                          <div class="form-group">{!! Form::input('number','quantity[]',null, ['class' => 'form-control calcEvent quantity input-sm text-center', 'id'=>"quantity" , 'required', 'step' => 'any', 'min' => '0']) !!}</div>
                        </td>
                      </tr>
                    </tbody>
                  </table>
                </div>
                <div class="col-md-6">
                  <span id="btn_product_list_modal" class="btn btn-sm btn-primary "><i class="fa fa-plus"></i> {{ trans('application.add_from_products') }}</span>
                  {!! Form::submit(trans('Save'), ['class' => "btn btn-primary btn-sm"]) !!}
                </div>

                <div class="form-group">
                  <div class="col-sm-6"> </div>
                  <div class="col-sm-6">
                    <button type="button" onclick="myFunction()" class="btn btn-success">Scan Item</button>
                  </div>
                </div>
                 <div class="form-group">
                  <div class="col-sm-12">
                    <p id="demo"></p>

                  </div>
                </div>
                <div class="form-group">
                  <div class="col-sm-6"> </div>
                  <div class="col-sm-6">

                  </div>
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
        $('.date').pikaday({ field: document.getElementById('datepicker1'), firstDay: 1, format:'MM-DD-YYYY', autoclose:true, defaultDate: moment().toDate(), setDefaultDate: true });
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

  function myFunction() {
      var item;
      swal("Please enter SkuCode:", {
          content: "input",
          buttons: true,
        })
        .then((value) => {
         item = value;
         console.log("value " + value);
         if (item === null){
           return false;
         }

          if (item == "") {
            swal("Error!", "Must be input a code!", "error");
            return false;

          } else {
            /* AjaxController to Check if Item Exit  */

            $.ajax({
              method: "POST",
              url: url,
              error: function() {
                swal("Sorry!", "An error has occurred.", "error");
                console.log(token);
                return false;
              },
              data: {
                id: item,
                _token: token
              },
              success: function(data) {
                if (data.sku === undefined) {
                  $("#demo").append("SkuCode " + item + " Not Found !</b></br>");
                  swal("Sorry!", "Item Not Found!", "error");

                } else {
                  var last_row = $('#item_table tr:last');
                  if (last_row.find('input:text[name="item_name[]"]').val() !== '')
                  {
                    cloneRow();
                    // Assign data
                    var last_row = $('#item_table tr:last');
                    last_row.find('input:text[name="product_id[]"]').val(data.uuid);
                    last_row.find('input:text[name="item_name[]"]').val(data.name);
                    last_row.find('input:input[name="quantity[]"]').val('1');
                  }
                  else
                  {
                    last_row.find('input:text[name="product_id[]"]').val(data.uuid);
                    last_row.find('input:text[name="item_name[]"]').val(data.name);
                    last_row.find('input:input[name="quantity[]"]').val('1');
                  }
                  // $("#demo").append("<b>App " + data.sku + data.name + "</b></br>");
                }
                myFunction();
              }
            });
          }
          });
        //var item = prompt("Please enter SkuCode", "Sku001");

      }

    function cloneRow()
    {
      var tbody = document.getElementById('item_table').getElementsByTagName("tbody")[0];
      // create row
      var row = document.createElement("tr");
      // create table cell 1
      var td1 = document.createElement("td");
      var strHtml1 = "<span class='btn btn-danger btn-xs delete_row'><i class='fa fa-minus'></i></span> ";
      td1.innerHTML = strHtml1.replace(/!count!/g,count);

      // // create table cell 2
      var td2 = document.createElement("td");
      var strHtml2 = '<div class="form-group">{!! Form::text("item_name[]", null, ["class" => "form-control input-sm item_name", "id"=>"item_name" , "required", "readonly"]) !!}{!! Form::text("product_id[]", null, ["class" => "form-control input-sm item_name hidden", "id"=>"item_name" , "required"]) !!}</div>';
      td2.innerHTML = strHtml2.replace(/!count!/g,count);

      // create table cell 3
      var td3 = document.createElement("td");
      var strHtml3 = '<div class="form-group">{!! Form::input("number","quantity[]", null, ["class" => "form-control input-sm calcEvent quantity text-center", "id"=>"quantity" , "required", "step" => "any", "min" => "0"]) !!}</div> ';
      td3.innerHTML = strHtml3.replace(/!count!/g,count);

      // append data to row
      row.appendChild(td1);
      row.appendChild(td2);
      row.appendChild(td3);

      // add to count variable
      count = parseInt(count) + 1;

      // append row to table
      tbody.appendChild(row);
      row.className = 'item';
      $('tr.item:last select').chosen({width:'100%'});
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
