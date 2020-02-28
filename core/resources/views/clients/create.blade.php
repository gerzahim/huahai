@extends('modal')
@section('content')
<div class="modal-dialog">
  <div class="modal-content">
    <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
      <h5 class="modal-title">{{ trans('application.add_client') }}</h5>
    </div>
    {!! Form::open(['route' => ['clients.store'], 'class' => 'ajax-submit', 'id' => 'clientfrm']) !!}
    <div class="modal-body">
      @if (count($errors) > 0) {!! form_errors($errors) !!}
      @endif
      @include('clients.partials._form')
    </div>
    <div class="modal-footer">
      {!! form_buttons() !!}
    </div>
    {!! Form::close() !!}
  </div>
</div>
@stop
