@extends('modal')
@section('content')
<div class="modal-dialog" style="width:700px">
  <div class="modal-content">
    <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
      <h5 class="modal-title">{{trans('application.serial_number')}}</h5>
    </div>

    <div class="modal-body">
      <div class="row">
            <br>
            <div class="col-md-12">
              <div class="form-group">
                  <label for="transaction_items_serial_numbers_id">Total Serial Numbers: {{ count($serial_numbers) }}</label>
               </div>
            </div>

            <div class="col-md-12">
              <div class="form-group">
              <label for="transaction_items_serial_numbers_id">Serial Numbers</label>
              <select class="form-control input-sm chosen" id="transaction_items_serial_numbers_id" name="transaction_items_serial_numbers_id"> 
                    @foreach ($serial_numbers as $serial_number)
                      <option value="{{ $serial_number->uuid }}">{{ $serial_number->serial_number }}</option>
                    @endforeach
              </select>
        
              </div>
            </div>
          </div>
    </div>
    <div class="modal-footer">
      {!! Form::button('Delete Serial Number Product',['class'=>'btn btn-xs btn-success pull-left', 'id'=>'delete-serial-number-confirm'] ) !!} {!! Form::button('Cancel',['class'=>'btn btn-xs btn-danger','data-dismiss'=>'modal'] ) !!}
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
