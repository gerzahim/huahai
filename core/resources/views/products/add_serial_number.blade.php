@extends('modal')
@section('content')
<div class="modal-dialog" style="width:700px">
  <div class="modal-content">
    <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
      <h5 class="modal-title">{{trans('application.add_serial_number')}}</h5>
    </div>

    <div class="modal-body">
      <div class="row">
            <br>
            <div class="col-md-12">
                <div class="form-group">
                    <input type="radio" name="type_serial" id="type_serial_single" value="single" checked><label>Sigle</label>
                    <input type="radio" name="type_serial" id="type_serial_secuencial" value="secuencial"><label>Secuencial</label>
                </div>
            </div>
            <div class="col-md-12">
                <div class="form-group secuencial hidden">
                  {!! Form::label('serial_number_initial', trans('application.serial_number_initial').'*') !!} {!! Form::text('serial_number_initial', null, ['class' => 'form-control input-sm', 'id' => 'serial_number_initial', 'required']) !!}
                </div>
            </div>
            <div class="col-md-12">
                <div class="form-group secuencial hidden">
                  {!! Form::label('serial_number_final', trans('application.serial_number_final').'*') !!} {!! Form::text('serial_number_final', null, ['class' => 'form-control input-sm', 'id' => 'serial_number_final', 'required']) !!}
                </div>
            </div>
            <div class="col-md-12">
              <div class="form-group single">
                {!! Form::label('serial_number', trans('application.serial_number').'*') !!} {!! Form::text('serial_number', null, ['class' => 'form-control input-sm', 'id' => 'serial_number', 'required']) !!}

                {!! Form::text('transaction_id',null, ['class' => 'form-control input-sm item_name hidden', 'id'=>"transaction_id"]) !!}
                {!! Form::text('transaction_item_id',null, ['class' => 'form-control input-sm item_name hidden', 'id'=>"transaction_item_id"]) !!}
                {!! Form::text('product_id',null, ['class' => 'form-control input-sm item_name hidden', 'id'=>"product_id"]) !!}
                {!! Form::text('quantity',null, ['class' => 'form-control input-sm item_name hidden', 'id'=>"quantity"]) !!}
              </div>
            </div>
          </div>
    </div>
    <div class="modal-footer">
      {!! Form::button('Add Serial Number Product',['class'=>'btn btn-xs btn-success pull-left', 'id'=>'add-serial-number-confirm'] ) !!} {!! Form::button('Cancel',['class'=>'btn btn-xs btn-danger','data-dismiss'=>'modal'] ) !!}
    </div>
  </div>
</div>
<style>
  td,
  th {
    word-break: break-all;
  }
</style>
@stop
